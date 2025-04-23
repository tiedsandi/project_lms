@extends('layouts.admin-layout')
@extends('layouts.main')

@section('page-title', 'Learning Modules')

@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Learning Module List</h3>

      <a href="{{ route('module_ins.create', ['instructor' => $instructor->id]) }}" class="btn btn-primary">
          Tambah Modul
      </a>
    </div>

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
              <a href="{{ route('module_ins.edit', $module->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('module_ins.destroy', $module->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $module->name }}">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">Belum ada modul dibuat.</td>
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
