@extends('layouts.admin-layout')
@section('page-title', 'Edit Role')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Edit Role</h3>
</div>
<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('role.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="name" class="form-label">Nama Role <span class="text-danger">*</span></label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Administrator" value="{{ old('name', $role->name) }}" autofocus>
      @error('name')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-check mb-3 d-flex">
      <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $role->is_active) ? 'checked' : '' }}>
      <label for="is_active" class="form-check-label ms-2">Tandai role ini sebagai aktif.</label>
      @error('is_active')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="d-flex justify-content-end">
      <a href="{{ route('role.index') }}" class="btn btn-outline-secondary me-2" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Cancel</a>
      <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Update</button>
    </div>
  </form>
</section>

@endsection