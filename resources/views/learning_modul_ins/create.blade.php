@extends('layouts.admin-layout')
@section('page-title', 'Buat Learning Module')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Buat Learning Module</h3>
</div>

<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('module_ins.store') }}" method="POST">
    @csrf

    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">



    <div class="mb-3">
      <label for="name" class="form-label">Nama Modul <span class="text-danger">*</span></label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Dasar Pemrograman" value="{{ old('name') }}" autofocus>
      @error('name')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Deskripsi Modul</label>
      <textarea name="description" id="description" class="form-control" rows="4" placeholder="Deskripsi singkat modul">{{ old('description') }}</textarea>
      @error('description')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-check mb-3 d-flex">
      <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
      <label for="is_active" class="form-check-label ms-2">Tandai modul ini sebagai aktif.</label>
      @error('is_active')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-flex justify-content-end">
      <a href="{{ route('module_ins.index') }}" class="btn btn-outline-secondary me-2" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Cancel</a>
      <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Buat</button>
    </div>
  </form>
</section>

@endsection
