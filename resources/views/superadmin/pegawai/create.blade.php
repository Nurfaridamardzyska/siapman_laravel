@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Tipe Pegawai</h1>

    <form action="{{ route('superadmin.tipe-pegawai.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Kode</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Urutan</label>
            <input type="number" name="priority" id="priority" class="form-control" value="{{ old('priority', 0) }}">
        </div>

        <div class="form-check mb-2">
            <input type="checkbox" name="is_honorarium" id="is_honorarium" class="form-check-input" value="1" {{ old('is_honorarium') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_honorarium">Honorarium</label>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Status Aktif</label>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('superadmin.tipe-pegawai.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection