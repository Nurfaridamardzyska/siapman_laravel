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


@app.route('/')
def home():
    return jsonify({
        "message": "Face service aktif"
    })


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
        return jsonify({
            "message": str(e)
        }), 500


if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5001, debug=False)