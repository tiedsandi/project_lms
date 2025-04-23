@extends('layouts.admin-layout')
@section('page-title', 'Edit Learning Module Detail')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Edit Learning Module Detail</h3>
</div>

<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('detail_module.update', $detail_module->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="module" class="form-label">Pilih Module <span class="text-danger">*</span></label>
      <select name="module_id" id="module" class="form-select">
        <option value="" disabled>Pilih salah satu</option>
        @foreach ($learning_module as $module)
          <option value="{{ $module->id }}" {{ $detail_module->learning_module_id == $module->id ? 'selected' : '' }}>
            {{ $module->name }}
          </option>
        @endforeach
      </select>
      @error('module_id')
      <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="file_name" class="form-label">Nama File <span class="text-danger">*</span></label>
      <input type="text" name="file_name" id="file_name" class="form-control" 
             value="{{ old('file_name', $detail_module->file_name) }}" autofocus>
      @error('file_name')
      <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="file" class="form-label">Upload File (Kosongkan jika tidak diganti)</label>
      <input type="file" name="file" id="file" class="form-control">
      @error('file')
      <div class="text-danger small">{{ $message }}</div>
      @enderror

      @if ($detail_module->file)
        <small class="text-muted d-block mt-1">
          File saat ini: 
          <a href="{{ asset('storage/' . $detail_module->file) }}" target="_blank">Lihat File</a>
        </small>
      @endif
    </div>

    <div class="mb-3">
      <label for="reference_link" class="form-label">Link Referensi (Opsional)</label>
      <input type="url" name="reference_link" id="reference_link" class="form-control" 
             value="{{ old('reference_link', $detail_module->reference_link) }}" placeholder="https://contoh.com">
      @error('reference_link')
      <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Update</button>
    </div>
  </form>
</section>

@endsection
