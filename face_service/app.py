<<<<<<< Updated upstream
from flask import Flask, request, jsonify
import face_recognition
import numpy as np
import os
import uuid

from flask import Flask, request, jsonify
import face_recognition

app = Flask(__name__)

# Simpan encoding wajah di memory
# format: { "user_id": encoding }
known_faces = {}
=======
from flask import Flask, Response, jsonify, request
import cv2
import time
import threading
import face_recognition
import os
import pickle
import numpy as np

app = Flask(__name__)

# Settings
KNOWN_FACES_DIR = os.path.join(os.path.dirname(__file__), "known_faces")
if not os.path.exists(KNOWN_FACES_DIR):
    os.makedirs(KNOWN_FACES_DIR)

# Global State for Streaming (Dashboard)
_state_lock = threading.Lock()
_camera = None
_cascade = None
_validation_running = False
_first_detected_at = None
_last_seen_at = None
_status_text = "Idle"
_valid = False
_elapsed_sec = 0.0

VALIDATION_SECONDS = 10.0
CAMERA_INDEX = 0

# Store for encodings in memory (loaded from disk)
_known_faces = {}

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

# Initial load
load_known_faces()

def _get_cascade():
    global _cascade
    if _cascade is None:
        _cascade = cv2.CascadeClassifier(
            cv2.data.haarcascades + "haarcascade_frontalface_default.xml"
        )
    return _cascade

def _get_camera():
    global _camera
    if _camera is None or not _camera.isOpened():
        _camera = cv2.VideoCapture(CAMERA_INDEX)
    return _camera

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
        _last_seen_at = now
        return
    if not _validation_running:
        _validation_running = True
        _first_detected_at = now
        _last_seen_at = now
        _status_text = "Detecting..."
        _elapsed_sec = 0.0
        return
    _last_seen_at = now
    _elapsed_sec = float(now - _first_detected_at) if _first_detected_at else 0.0
    _status_text = "Hold still..."
    if _elapsed_sec >= VALIDATION_SECONDS:
        _valid = True
        _status_text = "Wajah Valid"
        _elapsed_sec = VALIDATION_SECONDS
>>>>>>> Stashed changes

@app.route('/')
def home():
    return jsonify({
        "message": "Face service aktif",
        "registered_users": list(_known_faces.keys())
    })

@app.route('/register', methods=['POST'])
def register():
    try:
        if 'face_image' not in request.files:
            return jsonify({"message": "File face_image tidak ditemukan"}), 400
        
        user_id = request.form.get('user_id')
        if not user_id:
            return jsonify({"message": "user_id wajib dikirim"}), 400
        
        user_id = str(user_id)
        file = request.files['face_image']
        
        # Load image and encode
        image = face_recognition.load_image_file(file)
        encodings = face_recognition.face_encodings(image)
        
        if len(encodings) == 0:
            return jsonify({"message": "Wajah tidak terdeteksi pada gambar"}), 422
        
        encoding = encodings[0]
        
        # Save encoding persistently
        with open(os.path.join(KNOWN_FACES_DIR, f"{user_id}.pkl"), "wb") as f:
            pickle.dump(encoding, f)
        
        # Update memory
        _known_faces[user_id] = encoding
        
        return jsonify({
            "message": "wajah berhasil didaftarkan",
            "user_id": user_id
        }), 200

    except Exception as e:
        return jsonify({"message": str(e)}), 500

@app.route('/verify', methods=['POST'])
def verify():
    try:
        if 'face_image' not in request.files:
            return jsonify({"message": "File face_image tidak ditemukan"}), 400
        
        user_id = request.form.get('user_id')
        if not user_id:
            return jsonify({"message": "user_id wajib dikirim"}), 400
        
        user_id = str(user_id)
        
        if user_id not in _known_faces:
            return jsonify({
                "matched": False,
                "message": "Wajah user belum terdaftar",
                "confidence": None,
                "distance": None
            }), 404

        file = request.files['face_image']
        image = face_recognition.load_image_file(file)
        encodings = face_recognition.face_encodings(image)
        
        if len(encodings) == 0:
            return jsonify({
                "matched": False,
                "message": "Wajah tidak terdeteksi",
                "confidence": None,
                "distance": None
            }), 422

        unknown_encoding = encodings[0]
        known_encoding = _known_faces[user_id]
        
        # Calculate distance
        distance = face_recognition.face_distance([known_encoding], unknown_encoding)[0]
        
        threshold = 0.5
        matched = distance < threshold
        confidence = 1 - float(distance)
        
        return jsonify({
            "matched": bool(matched),
            "message": "Wajah dikenali" if matched else "Wajah tidak dikenali",
            "confidence": float(confidence),
            "distance": float(distance)
        }), 200 if matched else 422

    except Exception as e:
        return jsonify({"message": str(e)}), 500

@app.route('/register', methods=['POST'])
def register():
    try:
        if 'face_image' not in request.files:
            return jsonify({
                "message": "File face_image tidak ditemukan"
            }), 400

        user_id = request.form.get('user_id')
        if not user_id:
            return jsonify({
                "message": "user_id wajib dikirim"
            }), 400

        file = request.files['face_image']
        image = face_recognition.load_image_file(file)
        encodings = face_recognition.face_encodings(image)

        if len(encodings) == 0:
            return jsonify({
                "message": "Wajah tidak terdeteksi pada gambar"
            }), 422

        known_faces[str(user_id)] = encodings[0]

        return jsonify({
            "message": "wajah berhasil didaftarkan",
            "user_id": str(user_id)
        }), 200

<<<<<<< Updated upstream
    except Exception as e:
        return jsonify({
            "message": str(e)
        }), 500


@app.route('/verify', methods=['POST'])
def verify():
    try:
        if 'face_image' not in request.files:
            return jsonify({
                "message": "File face_image tidak ditemukan"
            }), 400

        user_id = request.form.get('user_id')
        if not user_id:
            return jsonify({
                "message": "user_id wajib dikirim"
            }), 400

        user_id = str(user_id)

        file = request.files['face_image']
        image = face_recognition.load_image_file(file)
        encodings = face_recognition.face_encodings(image)

        if len(encodings) == 0:
            return jsonify({
                "matched": False,
                "message": "Wajah tidak terdeteksi",
                "confidence": None,
                "distance": None
            }), 422

        if user_id not in known_faces:
            return jsonify({
                "matched": False,
                "message": "Wajah user belum terdaftar",
                "confidence": None,
                "distance": None
            }), 404

        unknown_encoding = encodings[0]
        known_encoding = known_faces[user_id]

        distance = face_recognition.face_distance(
            [known_encoding],
            unknown_encoding
        )[0]
=======
def _annotate_frame(frame, faces):
    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)
    with _state_lock:
        text = _status_text
        elapsed = _elapsed_sec
        valid = _valid
    if valid:
        overlay = "Wajah Valid"
        color = (0, 200, 0)
    elif text in ("Detecting...", "Hold still..."):
        overlay = f"{text} {elapsed:.1f}/{VALIDATION_SECONDS:.0f}s"
        color = (0, 255, 255)
    else:
        overlay = "Idle"
        color = (255, 255, 255)
    cv2.putText(frame, overlay, (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 0.9, color, 2, cv2.LINE_AA)
    return frame

def _stream_frames():
    cap = _get_camera()
    cascade = _get_cascade()
    while True:
        ok, frame = cap.read()
        if not ok:
            time.sleep(0.05)
            continue
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        faces = cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(60, 60))
        now = time.time()
        with _state_lock:
            _update_validation_locked(face_detected=(len(faces) > 0), now=now)
        frame = _annotate_frame(frame, faces)
        ret, jpeg = cv2.imencode('.jpg', frame)
        if not ret:
            continue
        yield (b"--frame\r\nContent-Type: image/jpeg\r\n\r\n" + jpeg.tobytes() + b"\r\n")
>>>>>>> Stashed changes

        threshold = 0.5
        matched = distance < threshold
        confidence = 1 - float(distance)

<<<<<<< Updated upstream
        return jsonify({
            "matched": bool(matched),
            "message": "Wajah dikenali" if matched else "Wajah tidak dikenali",
            "confidence": float(confidence),
            "distance": float(distance)
        }), 200 if matched else 422

    except Exception as e:
        return jsonify({
            "message": str(e)
        }), 500
=======
@app.route('/reset', methods=['POST'])
def reset():
    with _state_lock:
        _reset_validation_locked()
    return jsonify({"message": "reset ok"}), 200
>>>>>>> Stashed changes

@app.route('/snapshot', methods=['GET'])
def snapshot():
    """Return a single JPEG frame from the camera (used by Flutter for attendance submission)."""
    cap = _get_camera()
    ok, frame = cap.read()
    if not ok:
        return jsonify({"message": "Gagal mengambil frame kamera"}), 500
    ret, jpeg = cv2.imencode('.jpg', frame)
    if not ret:
        return jsonify({"message": "Gagal encode frame"}), 500
    return Response(jpeg.tobytes(), mimetype='image/jpeg')

@app.route('/sync-all', methods=['POST'])
def sync_all():
    """Reload all known face encodings from disk."""
    load_known_faces()
    return jsonify({
        "message": f"Loaded {len(_known_faces)} face(s)",
        "registered_users": list(_known_faces.keys())
    }), 200

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5001, debug=False)