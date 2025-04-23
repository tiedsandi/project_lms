@extends('layouts.admin-layout')
@extends('layouts.main')

@section('page-title', 'Learning Module Details')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Learning Module Detail List</h3>
    </div>

    <form method="GET" action="{{ route('my-learning.index') }}" class="d-flex mb-3">
      <!-- Dropdown Instructor -->
      <select name="instructor_id" class="form-select me-2" onchange="this.form.submit()">
        <option value="">Pilih Instructor</option>
        @foreach ($instructors as $instructor)
          <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
            {{ $instructor->title }}
          </option>
        @endforeach
      </select>

      <!-- Dropdown Learning Module -->
      <select name="module_id" class="form-select me-2" onchange="this.form.submit()">
        <option value="">Pilih Modul</option>
        @foreach ($learning_modules as $module)
          <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
            {{ $module->name }}
          </option>
        @endforeach
      </select>

      <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    @if($detail_modules->isEmpty())
      <div class="text-center text-muted">Belum ada detail modul yang tersedia.</div>
    @else
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama File</th>
            <th>File</th>
            <th>Link Referensi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($detail_modules as $detail)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $detail->file_name }}</td>
              <td>
                @if ($detail->file)
                  <a href="{{ asset('storage/' . $detail->file) }}" target="_blank" class="btn btn-sm btn-info">Download PDF</a>
                @else
                  <span class="text-muted">Tidak ada file</span>
                @endif
              </td>
              <td>
                @if ($detail->reference_link)
                  <a href="{{ $detail->reference_link }}" target="_blank">{{ $detail->reference_link }}</a>
                @else
                  <span class="text-muted">Tidak ada link</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</section>
@endsection

@section('script')
<script>
  // Bisa ditambah JS custom kalau mau, sekarang belum perlu
</script>
@endsection
