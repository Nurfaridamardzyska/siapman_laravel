@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Pengguna</h1>
        <p class="mt-1 text-sm text-slate-500">Tambahkan akun pengguna baru ke sistem.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="font-semibold mb-1">Terjadi kesalahan:</div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-5xl">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-700">Form Tambah Pengguna</h2>
            </div>

            <form action="{{ route('superadmin.pengguna.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            NIP / NRP
                        </label>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            placeholder="Masukkan NIP atau NRP"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">- Pilih Role -</option>
                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            OPD / Unit Kerja
                        </label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}"
                            placeholder="Contoh: Dinas Pendidikan"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password"
                            placeholder="Masukkan password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation"
                            placeholder="Ulangi password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-3 block text-sm font-semibold text-slate-700">
                            Face Registration <span class="text-xs font-normal text-slate-500">(Opsional)</span>
                        </label>
                        <div id="face-scan-container" class="relative min-h-[280px] overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 p-6 transition-all duration-300">
                            <!-- Placeholder -->
                            <div id="camera-placeholder" class="flex h-full flex-col items-center justify-center py-4">
                                <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-blue-600 ring-8 ring-blue-50/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 7H2a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-8m-2-3a2 2 0 012-2h4a2 2 0 012 2v3h-8V4z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-800">Daftarkan Wajah</h3>
                                <p class="mt-2 max-w-xs text-center text-sm text-slate-500">Gunakan kamera untuk memindai wajah pengguna agar bisa melakukan presensi wajah.</p>
                                <button type="button" id="btn-start-camera" class="mt-8 flex items-center gap-2 rounded-xl bg-blue-600 px-8 py-3.5 text-sm font-semibold text-white shadow-xl shadow-blue-200 transition-all hover:bg-blue-700 active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Mulai Kamera
                                </button>
                            </div>

                            <!-- Active Camera -->
                            <div id="camera-active" class="hidden">
                                <div class="relative mx-auto aspect-square max-w-[320px] overflow-hidden rounded-full border-4 border-white bg-slate-900 shadow-2xl">
                                    <video id="video" class="h-full w-full object-cover grayscale-[20%]" autoplay playsinline></video>
                                    <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
                                        <div class="h-[80%] w-[80%] rounded-full border-2 border-dashed border-white/40 ring-4 ring-blue-500/20"></div>
                                    </div>
                                    <div class="absolute bottom-4 left-0 right-0 text-center">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-900/60 px-3 py-1 text-[10px] font-medium text-white backdrop-blur-md">
                                            <span class="flex h-1.5 w-1.5 animate-pulse rounded-full bg-blue-400"></span>
                                            POSISIKAN WAJAH DI DALAM LINGKARAN
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-8 flex justify-center gap-4">
                                    <button type="button" id="btn-capture" class="flex items-center gap-2 rounded-xl bg-blue-600 px-8 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Ambil Foto
                                    </button>
                                    <button type="button" id="btn-stop-camera" class="rounded-xl bg-white border border-slate-200 px-8 py-3.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all">
                                        Batal
                                    </button>
                                </div>
                            </div>

                            <!-- Preview Result -->
                            <div id="camera-preview" class="hidden">
                                <div class="relative mx-auto aspect-square max-w-[240px] overflow-hidden rounded-full border-4 border-white bg-slate-100 shadow-2xl ring-4 ring-blue-50">
                                    <img id="face-preview-img" src="" class="h-full w-full object-cover">
                                    <div class="absolute inset-0 bg-blue-600/10 mix-blend-overlay"></div>
                                </div>
                                <div class="mt-8 flex flex-col items-center">
                                    <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-1.5 text-sm font-medium text-emerald-600 ring-1 ring-emerald-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Foto Berhasil Diambil
                                    </div>
                                    <button type="button" id="btn-retake" class="flex items-center gap-2 text-sm font-bold text-blue-600 transition-all hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Foto Ulang
                                    </button>
                                </div>
                            </div>
                        </div>
                        <canvas id="canvas" class="hidden"></canvas>
                        <input type="hidden" name="face_image" id="face-image-input">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Status
                        </label>
                        <select name="status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const video = document.getElementById('video');
                        const canvas = document.getElementById('canvas');
                        const facePreviewImg = document.getElementById('face-preview-img');
                        const faceImageInput = document.getElementById('face-image-input');
                        const scanContainer = document.getElementById('face-scan-container');
                        
                        const placeholder = document.getElementById('camera-placeholder');
                        const activeCamera = document.getElementById('camera-active');
                        const previewUI = document.getElementById('camera-preview');
                        
                        const btnStart = document.getElementById('btn-start-camera');
                        const btnStop = document.getElementById('btn-stop-camera');
                        const btnCapture = document.getElementById('btn-capture');
                        const btnRetake = document.getElementById('btn-retake');
                        
                        let stream = null;

                        // Start Camera
                        btnStart.addEventListener('click', async function() {
                            try {
                                stream = await navigator.mediaDevices.getUserMedia({ 
                                    video: { 
                                        facingMode: 'user',
                                        width: { ideal: 640 },
                                        height: { ideal: 640 }
                                    } 
                                });
                                video.srcObject = stream;
                                
                                placeholder.classList.add('hidden');
                                activeCamera.classList.remove('hidden');
                                scanContainer.classList.add('ring-4', 'ring-blue-50', 'border-blue-200');
                                scanContainer.classList.remove('border-dashed');
                            } catch (err) {
                                console.error("Error accessing camera: ", err);
                                alert("Tidak dapat mengakses kamera. Pastikan memberikan izin akses kamera.");
                            }
                        });

                        // Stop Camera
                        function stopCamera() {
                            if (stream) {
                                stream.getTracks().forEach(track => track.stop());
                                video.srcObject = null;
                            }
                            activeCamera.classList.add('hidden');
                            placeholder.classList.remove('hidden');
                            scanContainer.classList.remove('ring-4', 'ring-blue-50', 'border-blue-200');
                            scanContainer.classList.add('border-dashed');
                        }

                        btnStop.addEventListener('click', stopCamera);

                        // Capture Photo
                        btnCapture.addEventListener('click', function() {
                            const context = canvas.getContext('2d');
                            canvas.width = video.videoWidth;
                            canvas.height = video.videoHeight;
                            
                            // Flip image horizontally for natural feel if needed
                            context.translate(canvas.width, 0);
                            context.scale(-1, 1);
                            context.drawImage(video, 0, 0, canvas.width, canvas.height);
                            
                            const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                            faceImageInput.value = dataUrl;
                            facePreviewImg.src = dataUrl;
                            
                            activeCamera.classList.add('hidden');
                            previewUI.classList.remove('hidden');
                            
                            stopCamera();
                        });

                        // Retake
                        btnRetake.addEventListener('click', function() {
                            previewUI.classList.add('hidden');
                            placeholder.classList.remove('hidden');
                            faceImageInput.value = '';
                        });
                    });
                </script>

                <div class="mt-8 flex gap-3 border-t border-slate-200 pt-6">
                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm text-white hover:bg-blue-700">
                        Simpan
                    </button>

                    <a href="{{ route('superadmin.pengguna.index') }}"
                        class="rounded-xl border border-slate-300 px-5 py-3 text-sm text-slate-700 hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection