@extends('layouts.admin-layout')
@section('page-title', 'Edit Instruktur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Edit Instruktur</h3>
</div>

<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('instructor.update', $instructor->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Nama Instruktur -->
    <div class="mb-3">
      <label for="name" class="form-label">Nama Instruktur <span class="text-danger">*</span></label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Web Programming" value="{{ old('name', $instructor->user->name ?? '') }}" autofocus>
      @error('name')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Akun -->
    <div class="mb-3">
      <label for="user_id" class="form-label">Akun</label>
      <select name="user_id" id="user_id" class="form-select">
        <option value="" disabled>Pilih Akun</option>
        @foreach($usersAsInstructors as $user)
          <option value="{{ $user->id }}" {{ (old('user_id', $instructor->user_id) == $user->id) ? 'selected' : '' }}>
            {{ $user->name }}
          </option>
        @endforeach
      </select>
      @error('user_id')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Major (Jurusan) -->
    <div class="mb-3">
      <label for="major_id" class="form-label">Jurusan</label>
      <select name="major_id" id="major_id" class="form-select">
        <option value="" selected>Pilih Jurusan</option>
        @foreach($majors as $major)
          <option value="{{ $major->id }}" {{ (old('major_id', $instructor->major_id) == $major->id) ? 'selected' : '' }}>
            {{ $major->name }}
          </option>
        @endforeach
      </select>
      @error('major_id')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Gender -->
    <div class="mb-3">
      <label for="gender" class="form-label">Jenis Kelamin</label>
      <select name="gender" id="gender" class="form-select">
        <option value="0" {{ old('gender', $instructor->gender) == 0 ? 'selected' : '' }}>Laki-laki</option>
        <option value="1" {{ old('gender', $instructor->gender) == 1 ? 'selected' : '' }}>Perempuan</option>
      </select>
      @error('gender')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Alamat -->
    <div class="mb-3">
      <label for="address" class="form-label">Alamat</label>
      <textarea name="address" id="address" class="form-control" rows="3">{{ old('address', $instructor->address) }}</textarea>
      @error('address')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Nomor Telepon -->
    <div class="mb-3">
      <label for="phone" class="form-label">Nomor Telepon</label>
      <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $instructor->phone) }}">
      @error('phone')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Foto -->
    <div class="mb-3">
      <label for="photo" class="form-label">Foto Instruktur</label>
      <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
      @if($instructor->photo)
        <small class="d-block mt-1">Foto saat ini: <a href="{{ asset('storage/'.$instructor->photo) }}" target="_blank">Lihat Foto</a></small>
      @endif
      @error('photo')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Status Aktif -->
    <div class="form-check mb-3 d-flex">
      <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $instructor->is_active) ? 'checked' : '' }}>
      <label for="is_active" class="form-check-label ms-2">Tandai Instruktur ini sebagai aktif.</label>
      @error('is_active')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Button -->
    <div class="d-flex justify-content-end">
      <a href="{{ route('instructor.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</section>
@endsection
