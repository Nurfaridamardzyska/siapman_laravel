@extends('layouts.app')

@section('content')
<div class="px-6 py-6 font-sans">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="group">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Edit Pengguna</h1>
            <p class="mt-1 text-sm font-medium text-slate-500">Kelola informasi kredensial, hak akses, dan biometrik untuk <b>{{ $user->name }}</b>.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 xl:flex flex-wrap items-center gap-2">
            <a href="{{ route('superadmin.pengguna.riwayat-login', $user->id) }}" class="inline-flex items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-black text-blue-700 tracking-widest uppercase transition-all hover:bg-blue-600 hover:text-white active:scale-95 shadow-sm shadow-blue-100/50">
                L-HIST
            </a>
            
            <a href="{{ route('superadmin.pengguna.perangkat', $user->id) }}" class="inline-flex items-center gap-2 rounded-xl border border-purple-200 bg-purple-50 px-4 py-2 text-xs font-black text-purple-700 tracking-widest uppercase transition-all hover:bg-purple-600 hover:text-white active:scale-95 shadow-sm shadow-purple-100/50">
                DEVICE
            </a>

            <a href="{{ route('superadmin.pengguna.lokasi-absen', $user->id) }}" class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700 tracking-widest uppercase transition-all hover:bg-emerald-600 hover:text-white active:scale-95 shadow-sm shadow-emerald-100/50">
                LOC
            </a>

            <form action="{{ route('superadmin.pengguna.reset', $user->id) }}" method="POST" onsubmit="return confirm('Bagikan password standar \'password123\' untuk pengguna ini?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-black text-rose-700 tracking-widest uppercase transition-all hover:bg-rose-600 hover:text-white active:scale-95 shadow-sm shadow-rose-100/50">
                    RESET
                </button>
            </form>

            <a href="{{ route('superadmin.pengguna.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-xs font-black text-slate-700 tracking-widest uppercase transition-all hover:bg-slate-50 active:scale-95">
                ESC
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700 animate-in fade-in slide-in-from-top-4">
            <div class="font-black uppercase tracking-widest text-[10px] mb-2 opacity-70">Terjadi Kesalahan Validasi</div>
            <ul class="list-disc pl-5 space-y-1 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-6xl">
        <form action="{{ route('superadmin.pengguna.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Form Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-between">
                            <h2 class="text-[10px] font-black uppercase tracking-widest text-slate-400">Account Credentials</h2>
                        </div>

                        <div class="p-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1 tracking-tight">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1 tracking-tight">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-400 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1 tracking-tight">Email Recovery</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1 tracking-tight">NIP / NRP</label>
                                <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" required
                                    class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1 tracking-tight">Role Authority</label>
                                <select name="role" required
                                    class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm font-black uppercase tracking-wider text-slate-600 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none cursor-pointer">
                                    <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>SUPERADMIN</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>ADMIN</option>
                                    <option value="pegawai" {{ old('role', $user->role) == 'pegawai' ? 'selected' : '' }}>PEGAWAI</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1 tracking-tight">Penempatan OPD <span class="text-rose-500">*</span></label>
                                <select name="department_id" required
                                    class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm font-black uppercase tracking-wider text-slate-600 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none cursor-pointer">
                                    <option value="">- Pilih OPD -</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1 tracking-tight">Detail Unit Kerja <span class="text-rose-500">*</span></label>
                                <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $user->unit_kerja) }}" required
                                    class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none">
                            </div>

                            <div class="space-y-2 border-t border-slate-100 pt-4 md:col-span-2">
                                <div class="flex items-center justify-between mb-2 px-1">
                                    <label class="text-sm font-extrabold text-slate-800 tracking-tight">Ubah Kata Sandi</label>
                                    <span class="text-[10px] font-black text-slate-300 uppercase italic">Leave blank to keep current</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="password" name="password" placeholder="Password Baru" autocomplete="new-password"
                                        class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none tracking-widest">
                                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Ulang" autocomplete="new-password"
                                        class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none tracking-widest">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm p-6">
                        <label class="flex cursor-pointer items-center gap-4 group">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                class="h-6 w-6 rounded-lg border-slate-300 text-emerald-600 focus:ring-emerald-500/20 transition group-hover:scale-110">
                            <div>
                                <p class="text-sm font-black text-slate-800 tracking-tight">Akun Berstatus Aktif</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase leading-relaxed tracking-wider">Uncheck to revoke access immediately</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Right: Face Scan -->
                <div class="space-y-6">
                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg p-6 flex flex-col items-center">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6 w-full text-center">Biometric Identity</h2>
                        
                        @php
                            $activeFace = $user->employee ? $user->employee->activeFace : null;
                        @endphp

                        <div id="face-scan-container" class="relative group w-full aspect-square max-w-[240px] overflow-hidden rounded-full bg-slate-100 border-4 border-slate-50 shadow-inner ring-8 ring-slate-50 transition-all duration-500">
                            
                            @if($activeFace)
                            <!-- Existing Face -->
                            <div id="existing-face-ui" class="h-full flex flex-col items-center justify-center relative">
                                <img src="{{ asset('storage/' . $activeFace->image_path) }}" class="h-full w-full object-cover grayscale-[30%]">
                                <div class="absolute inset-0 bg-indigo-900/10 mix-blend-multiply"></div>
                                <div class="absolute bottom-4 left-0 right-0 flex justify-center">
                                    <button type="button" id="btn-re-scan" class="bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-[9px] font-black text-indigo-700 shadow-xl hover:bg-white transition active:scale-95 uppercase tracking-widest">UPDATE PHOTO</button>
                                </div>
                            </div>
                            @endif

                            <!-- Placeholder -->
                            <div id="camera-placeholder" class="{{ $activeFace ? 'hidden' : '' }} h-full flex flex-col items-center justify-center p-8 text-center">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-md text-blue-600 mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                </div>
                                <h3 class="text-xs font-black text-slate-800 tracking-tight">No Active Model</h3>
                                <button type="button" id="btn-start-camera" class="mt-4 w-full rounded-xl bg-slate-800 py-2.5 text-xs font-bold text-white hover:bg-slate-900 transition active:scale-95">RE-SCAN</button>
                            </div>

                            <!-- Active Video -->
                            <div id="camera-active" class="hidden h-full">
                                <video id="video" class="h-full w-full object-cover scale-x-[-1]" autoplay playsinline></video>
                                <div class="absolute bottom-4 left-0 right-0 flex justify-center">
                                     <button type="button" id="btn-capture" class="h-12 w-12 rounded-full bg-white border-2 border-slate-200 shadow-xl flex items-center justify-center text-slate-800 active:scale-90">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                                     </button>
                                </div>
                                <button type="button" id="btn-stop-camera" class="absolute top-3 right-6 text-white text-xs font-bold">CANCEL</button>
                            </div>

                            <!-- Preview -->
                            <div id="camera-preview" class="hidden h-full">
                                <img id="face-preview-img" src="" class="h-full w-full object-cover">
                                <div class="absolute bottom-4 left-0 right-0 flex flex-col items-center gap-1">
                                    <span class="bg-blue-600 text-white text-[8px] font-black uppercase px-2 py-0.5 rounded-full">NEW SCAN READY</span>
                                    <button type="button" id="btn-retake" class="text-white drop-shadow-md text-[9px] font-black uppercase tracking-widest">RETAKE</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-1 w-full gap-2 opacity-60">
                             <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-[9px] font-bold text-slate-500 leading-tight uppercase tracking-widest">Scan ulang jika pegawai mengalami kendala saat validasi wajah di aplikasi.</p>
                             </div>
                        </div>
                        
                        <canvas id="canvas" class="hidden"></canvas>
                        <input type="hidden" name="face_image" id="face-image-input">
                    </div>

                    <button type="submit" 
                            class="w-full rounded-2xl bg-slate-800 py-4 text-xs font-black text-white shadow-xl shadow-slate-200 transition-all hover:bg-slate-900 active:scale-95 flex items-center justify-center gap-3 tracking-[0.2em]">
                        UPDATE PENGGUNA
                    </button>
                </div>
            </div>
        </form>
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
        const existingFaceUI = document.getElementById('existing-face-ui');
        
        const btnStart = document.getElementById('btn-start-camera');
        const btnStop = document.getElementById('btn-stop-camera');
        const btnCapture = document.getElementById('btn-capture');
        const btnRetake = document.getElementById('btn-retake');
        const btnReScan = document.getElementById('btn-re-scan');
        
        let stream = null;

        if(btnReScan) {
            btnReScan.addEventListener('click', () => {
                existingFaceUI.classList.add('hidden');
                placeholder.classList.remove('hidden');
            });
        }

        btnStart.addEventListener('click', async function() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                video.srcObject = stream;
                placeholder.classList.add('hidden');
                activeCamera.classList.remove('hidden');
            } catch (err) { alert("ERROR_CAMERA_ACCESS"); }
        });

        function stopCamera() {
            if (stream) { stream.getTracks().forEach(track => track.stop()); }
            activeCamera.classList.add('hidden');
        }

        btnStop.addEventListener('click', () => {
            stopCamera();
            if(existingFaceUI) {
                placeholder.classList.add('hidden');
                existingFaceUI.classList.remove('hidden');
            } else {
                placeholder.classList.remove('hidden');
            }
        });

        btnCapture.addEventListener('click', function() {
            canvas.width = video.videoWidth; canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.translate(canvas.width, 0); ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0);
            
            const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
            faceImageInput.value = dataUrl;
            facePreviewImg.src = dataUrl;
            activeCamera.classList.add('hidden');
            previewUI.classList.remove('hidden');
            stopCamera();
        });

        btnRetake.addEventListener('click', function() {
            previewUI.classList.add('hidden');
            placeholder.classList.remove('hidden');
            faceImageInput.value = '';
        });
    });
</script>
@endsection