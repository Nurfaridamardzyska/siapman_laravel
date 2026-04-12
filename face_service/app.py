from flask import Flask, Response, jsonify, request
import cv2
import time
import threading

app = Flask(__name__)

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


@app.route('/')
def home():
    return jsonify({
        "message": "Face service aktif"
    })


@app.route('/status', methods=['GET'])
def status():
    with _state_lock:
        return jsonify({
            "valid": bool(_valid),
            "status": str(_status_text),
            "elapsed": float(_elapsed_sec),
            "required": float(VALIDATION_SECONDS),
            "validation_running": bool(_validation_running),
        }), 200


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

    cv2.putText(
        frame,
        overlay,
        (10, 30),
        cv2.FONT_HERSHEY_SIMPLEX,
        0.9,
        color,
        2,
        cv2.LINE_AA,
    )
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
        faces = cascade.detectMultiScale(
            gray,
            scaleFactor=1.1,
            minNeighbors=5,
            minSize=(60, 60),
        )

        now = time.time()
        with _state_lock:
            _update_validation_locked(face_detected=(len(faces) > 0), now=now)

        frame = _annotate_frame(frame, faces)

        ret, jpeg = cv2.imencode('.jpg', frame)
        if not ret:
            continue

        yield (
            b"--frame\r\n"
            b"Content-Type: image/jpeg\r\n\r\n" + jpeg.tobytes() + b"\r\n"
        )


@app.route('/stream', methods=['GET'])
def stream():
    return Response(_stream_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')


@app.route('/reset', methods=['POST'])
def reset():
    with _state_lock:
        _reset_validation_locked()
    return jsonify({"message": "reset ok"}), 200


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001, debug=False, threaded=True)