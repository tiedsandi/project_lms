@extends('layouts.admin-layout')
@section('page-title', 'Tambah Learning Module Detail')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Tambah Learning Module Detail</h3>
</div>

<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('learning_module_detail.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- Hidden learning_module_id --}}
    <input type="hidden" name="learning_module_id" value="{{ $module->id }}">

    <div class="mb-3">
      <label for="file_name" class="form-label">Nama File <span class="text-danger">*</span></label>
      <input type="text" name="file_name" id="file_name" class="form-control" placeholder="Contoh: Modul Pertemuan 1" value="{{ old('file_name') }}" autofocus>
      @error('file_name')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="file" class="form-label">Upload File</label>
      <input type="file" name="file" id="file" class="form-control">
      @error('file')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="reference_link" class="form-label">Link Referensi (Opsional)</label>
      <input type="url" name="reference_link" id="reference_link" class="form-control" placeholder="https://contoh.com" value="{{ old('reference_link') }}">
      @error('reference_link')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-flex justify-content-end">
      <a href="{{ route('learning_module.index') }}" class="btn btn-outline-secondary me-2" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Cancel</a>
      <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Simpan</button>
    </div>
  </form>
</section>

@endsection
