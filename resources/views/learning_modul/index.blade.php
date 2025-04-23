@extends('layouts.admin-layout')
@extends('layouts.main')
@section('page-title', 'Learning Modules')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Learning Module List</h3>
      @if(request('instructor_id'))
        <a href="{{ route('learning_module.create', ['instructor' => request('instructor_id')]) }}" class="btn btn-primary">
            Tambah Modul
        </a>
      @endif   
    </div>

    <form method="GET" action="{{ route('learning_module.index') }}" class="d-flex mb-3">
      <select name="major_id" class="form-select me-2" onchange="this.form.submit()">
        <option value="">Pilih Major</option>
        @foreach ($majors as $major)
          <option value="{{ $major->id }}" {{ request('major_id') == $major->id ? 'selected' : '' }}>
            {{ $major->name }}
          </option>
        @endforeach
      </select>

      @if (!empty($instructors))
        <select name="instructor_id" class="form-select me-2" onchange="this.form.submit()">
          <option value="">Pilih Instructor</option>
          @foreach ($instructors as $instructor)
            <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
              {{ $instructor->title }}
            </option>
          @endforeach
        </select>
      @endif
    </form>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Modul</th>
          <th>Deskripsi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($modules as $module)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $module->name }}</td>
            <td>{{ $module->description }}</td>
            <td>
              <a href="{{ route('learning_module.edit', $module->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('learning_module.destroy', $module->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $module->name }}">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">Data tidak ada.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>
@endsection

@section('script')
<script>
  $('.btn-hapus').click(function(e) {
    e.preventDefault(); 
    
    var form = $(this).closest('form');
    var moduleName = $(this).data('name');

    Swal.fire({
      title: `Hapus "${moduleName}"?`,
      text: "Apakah anda yakin ingin menghapus modul ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
</script>
@endsection
