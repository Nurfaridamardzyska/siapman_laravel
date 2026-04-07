@extends('layouts.app')

@section('content')
<div class="px-6 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Hari Libur</h1>
        <p class="mt-1 text-sm text-slate-500">Isi data hari libur dengan lengkap.</p>
    </div>

    <div class="max-w-4xl">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-700">Form Hari Libur</h2>
            </div>

            <form action="{{ route('superadmin.hari-libur.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        @error('name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" value="{{ old('date') }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        @error('date')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Jenis <span class="text-red-500">*</span></label>
                        <select name="type"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">- Pilih Jenis -</option>
                            <option value="Nasional" {{ old('type') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="Cuti Bersama" {{ old('type') == 'Cuti Bersama' ? 'selected' : '' }}>Cuti Bersama</option>
                            <option value="Hari Besar Agama" {{ old('type') == 'Hari Besar Agama' ? 'selected' : '' }}>Hari Besar Agama</option>
                            <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Tahun</label>
                        <input type="number" name="year" value="{{ old('year') }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        @error('year')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Instansi ID</label>
                        <input type="number" name="company_id" value="{{ old('company_id', 0) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        @error('company_id')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col justify-end gap-4">
                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <input type="checkbox" name="is_nasional" value="1"
                                   {{ old('is_nasional', 1) ? 'checked' : '' }}
                                   class="h-5 w-5 rounded border-slate-300 text-green-600 focus:ring-green-500">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Libur Nasional</p>
                                <p class="text-xs text-slate-500">Centang jika berlaku nasional</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <input type="checkbox" name="is_recurring" value="1"
                                   {{ old('is_recurring') ? 'checked' : '' }}
                                   class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Berulang Tiap Tahun</p>
                                <p class="text-xs text-slate-500">Contoh: 17 Agustus</p>
                            </div>
                        </label>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Keterangan</label>
                        <textarea name="description" rows="4"
                                  class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-6">
                    <button type="submit"
                            class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                        Simpan
                    </button>

                    <a href="{{ route('superadmin.hari-libur.index') }}"
                       class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection