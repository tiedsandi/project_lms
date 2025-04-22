@extends('layouts.admin-layout')
@section('page-title', 'Edit User')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Edit User</h3>
</div>
<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="name" class="form-label">Nama User <span class="text-danger">*</span></label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Joko Boyo" value="{{ old('name', $user->name) }}" autofocus>
      @error('name')
      <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email User <span class="text-danger">*</span></label>
      <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: joko@gmail.com" value="{{ old('email', $user->email) }}">
      @error('email')
      <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password (Opsional)</label>
      <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru jika ingin mengganti">
        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
          <i class="bi bi-eye"></i>
        </button>
      </div>
      @error('password')
      <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Pilih Role <span class="text-danger">*</span></label>
      <select name="role_id" id="role" class="form-select">
        <option value="" disabled>Pilih salah satu</option>
        @foreach ($roles as $role)
        <option value="{{ $role->id }}" {{ old('role_id', $user->userRoles[0]->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
        @endforeach
      </select>
      @error('role_id')
      <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="d-flex justify-content-end">
      <a href="{{ route('user.index') }}" class="btn btn-outline-secondary me-2" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Batal</a>
      <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Perbarui</button>
    </div>
  </form>
</section>

@endsection

@section('script')
<script>
  $('#togglePassword').on('click', function() {
    const passwordField = $('#password');
    const icon = $(this).find('i');
    if (passwordField.attr('type') === 'password') {
      passwordField.attr('type', 'text');
      icon.removeClass('bi-eye').addClass('bi-eye-slash');
    } else {
      passwordField.attr('type', 'password');
      icon.removeClass('bi-eye-slash').addClass('bi-eye');
    }
  });
</script>
@endsection
