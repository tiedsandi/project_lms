@extends('layouts.admin-layout')

@section('page-title', 'Buat Murid')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Buat Murid</h3>
</div>

<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('murid.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Nama Murid -->
    <div class="mb-3">
      <label for="name" class="form-label">Nama Murid <span class="text-danger">*</span></label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" autofocus>
      @error('name')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Akun -->
    <div class="mb-3">
      <div class="d-flex align-items-center justify-content-between gap-2">
        <label for="user_id" class="form-label">Akun</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="create_account" name="create_account" value="1" {{ old('create_account') ? 'checked' : '' }}>
          <label class="form-check-label" for="create_account">Buat Akun</label>
        </div>
      </div>

      <select name="user_id" id="user_id" class="form-select">
        <option value="" disable selected>Pilih Akun</option>
        @foreach($usersAsStudents as $user)
          <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
        @endforeach
      </select>
      @error('user_id')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
      @error('create_account')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Major (Jurusan) -->
    <div class="mb-3">
      <label for="major_id" class="form-label">Jurusan</label>
      <select name="major_id" id="major_id" class="form-select">
        <option value="" selected>Pilih Jurusan</option>
        @foreach($majors as $major)
          <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
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
        <option value="0" {{ old('gender') == 0 ? 'selected' : '' }}>Laki-laki</option>
        <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Perempuan</option>
      </select>
      @error('gender')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Tempat Lahir -->
    <div class="mb-3">
      <label for="palace_of_birth" class="form-label">Tempat Lahir</label>
      <input type="text" name="palace_of_birth" id="palace_of_birth" class="form-control" placeholder="Contoh: Jakarta" value="{{ old('palace_of_birth') }}">
      @error('palace_of_birth')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Tanggal Lahir -->
    <div class="mb-3">
      <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
      <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
      @error('date_of_birth')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Nomor Telepon -->
    <div class="mb-3">
      <label for="phone" class="form-label">Nomor Telepon</label>
      <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
      @error('phone')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Foto -->
    <div class="mb-3">
      <label for="photo" class="form-label">Foto Murid</label>
      <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
      @error('photo')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Status Aktif -->
    <div class="form-check mb-3 d-flex">
      <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active') == '1' ? 'checked' : '' }}>
      <label for="is_active" class="form-check-label ms-2">Tandai Murid ini sebagai aktif.</label>
      @error('is_active')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>

    <!-- Button -->
    <div class="d-flex justify-content-end">
      <a href="{{ route('murid.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
      <button type="submit" class="btn btn-primary">Buat</button>
    </div>
  </form>
</section>
@endsection

@section('script')
<script>
  $(document).ready(function() {
    function toggleUserPic() {
      if ($('#create_account').is(':checked')) {
        $('#user_id').prop('disabled', true);
      } else {
        $('#user_id').prop('disabled', false);
      }
    }

    $('#create_account').change(function() {
      toggleUserPic();
    });

    toggleUserPic(); // Untuk inisialisasi saat halaman load
  });
</script>
@endsection
