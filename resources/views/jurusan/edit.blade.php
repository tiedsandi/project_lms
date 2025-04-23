@extends('layouts.admin-layout')
@section('page-title', 'Edit Jurusan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Edit Jurusan</h3>
</div>
<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('major.update', $major->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="name" class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Web Programming" value="{{ old('name', $major->name) }}" autofocus>
      @error('name')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="user_pic" class="form-label">Penanggung Jawab (PIC) </label>
      <select name="user_pic" id="user_pic" class="form-select">
      <option value="" >Pilih Penanggung Jawab</option>
      @foreach($usersPIC as $user)
        <option value="{{ $user->id }}" {{ old('user_pic', $major->user_pic) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
      @endforeach
      </select>
      @error('user_pic')
      <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-check mb-3 d-flex">
      <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $major->is_active) ? 'checked' : '' }}>
      <label for="is_active" class="form-check-label ms-2">Tandai jurusan ini sebagai aktif.</label>
      @error('is_active')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="d-flex justify-content-end">
      <a href="{{ route('major.index') }}" class="btn btn-outline-secondary me-2" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Cancel</a>
      <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Update</button>
    </div>
  </form>
</section>

@endsection