from flask import Flask, Response, jsonify, request
import cv2
import time
import threading
import face_recognition
import os
import pickle
import numpy as np

app = Flask(__name__)

# ================= SETTINGS =================
KNOWN_FACES_DIR = os.path.join(os.path.dirname(__file__), "known_faces")
if not os.path.exists(KNOWN_FACES_DIR):
    os.makedirs(KNOWN_FACES_DIR)

VALIDATION_SECONDS = 10.0
CAMERA_INDEX = 0

# ================= GLOBAL STATE =================
_state_lock = threading.Lock()
_camera = None
_cascade = None
_validation_running = False
_first_detected_at = None
_last_seen_at = None
_status_text = "Idle"
_valid = False
_elapsed_sec = 0.0

_known_faces = {}

# ================= LOAD FACES =================
def load_known_faces():
    global _known_faces
    _known_faces = {}
    for filename in os.listdir(KNOWN_FACES_DIR):
        if filename.endswith(".pkl"):
            user_id = filename.replace(".pkl", "")
            try:
                with open(os.path.join(KNOWN_FACES_DIR, filename), "rb") as f:
                    _known_faces[user_id] = pickle.load(f)
            except Exception as e:
                print(f"Error loading {filename}: {e}")

load_known_faces()

# ================= CAMERA =================
def _get_camera():
    global _camera
    if _camera is None or not _camera.isOpened():
        _camera = cv2.VideoCapture(CAMERA_INDEX)
    return _camera

def _get_cascade():
    global _cascade
    if _cascade is None:
        _cascade = cv2.CascadeClassifier(
            cv2.data.haarcascades + "haarcascade_frontalface_default.xml"
        )
    return _cascade

# ================= VALIDATION =================
def _reset_validation_locked():
    global _validation_running, _first_detected_at, _last_seen_at, _status_text, _valid, _elapsed_sec
    _validation_running = False
    _first_detected_at = None
    _last_seen_at = None
    _status_text = "Idle"
    _valid = False
    _elapsed_sec = 0.0

def _update_validation_locked(face_detected: bool, now: float):
    global _validation_running, _first_detected_at, _last_seen_at, _status_text, _valid, _elapsed_sec

    if not face_detected:
        _reset_validation_locked()
        return

    if _valid:
        _status_text = "Wajah Valid"
        _elapsed_sec = VALIDATION_SECONDS
        return

    if not _validation_running:
        _validation_running = True
        _first_detected_at = now
        _status_text = "Detecting..."
        return

    _elapsed_sec = float(now - _first_detected_at)
    _status_text = "Hold still..."

    if _elapsed_sec >= VALIDATION_SECONDS:
        _valid = True
        _status_text = "Wajah Valid"

# ================= ROUTES =================
@app.route('/')
def home():
    return jsonify({
        "message": "Face service aktif",
        "registered_users": list(_known_faces.keys())
    })

@app.route('/register', methods=['POST'])
def register():
    try:
        file = request.files['face_image']
        user_id = request.form.get('user_id')

        image = face_recognition.load_image_file(file)
        encoding = face_recognition.face_encodings(image)[0]

        with open(os.path.join(KNOWN_FACES_DIR, f"{user_id}.pkl"), "wb") as f:
            pickle.dump(encoding, f)

        _known_faces[user_id] = encoding

        return jsonify({"message": "wajah berhasil didaftarkan"})

    except Exception as e:
        return jsonify({"message": str(e)}), 500

@app.route('/verify', methods=['POST'])
def verify():
    try:
        file = request.files['face_image']
        user_id = request.form.get('user_id')

        image = face_recognition.load_image_file(file)
        unknown_encoding = face_recognition.face_encodings(image)[0]

        known_encoding = _known_faces[user_id]
        distance = face_recognition.face_distance([known_encoding], unknown_encoding)[0]

        return jsonify({
            "matched": bool(distance < 0.5),
            "distance": float(distance)
        })

    except Exception as e:
        return jsonify({"message": str(e)}), 500

@app.route('/status')
def status():
    return jsonify({
        "valid": _valid,
        "status": _status_text,
        "elapsed": _elapsed_sec
    })

@app.route('/reset', methods=['POST'])
def reset():
    with _state_lock:
        _reset_validation_locked()
    return jsonify({"message": "reset ok"})

# ================= STREAM =================
def _annotate_frame(frame, faces):
    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x+w, y+h), (0,255,0), 2)
    return frame

def _stream_frames():
    cap = _get_camera()
    cascade = _get_cascade()

    while True:
        ok, frame = cap.read()
        if not ok:
            continue

        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        faces = cascade.detectMultiScale(gray)

        now = time.time()
        with _state_lock:
            _update_validation_locked(len(faces) > 0, now)

        frame = _annotate_frame(frame, faces)
        _, jpeg = cv2.imencode('.jpg', frame)

        yield (b'--frame\r\nContent-Type: image/jpeg\r\n\r\n' + jpeg.tobytes() + b'\r\n')

@app.route('/stream')
def stream():
    return Response(_stream_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

# ================= MAIN =================
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)