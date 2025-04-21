@extends('layouts.admin-layout')
@extends('layouts.main')
@section('page-title', 'Jurusan')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>List Jurusan</h3>
      <a href="{{ route('major.create') }}" class="btn btn-primary">Tambah Jurusan</a>
    </div>


    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
            <th>Status Aktif</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($majors as $major)
          <tr>
            <td>{{ $majors->firstItem() + $loop->iteration - 1 }}</td>
            <td>{{ $major->name }}</td>
            <td>
              <span class="badge {{ $major->is_active == 1 ? 'bg-success' : 'bg-secondary' }}">
                {{ $major->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
              </span>
            </td></td>
            <td>
              <a href="{{ route('major.edit', $major->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('major.destroy', $major->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $major->name }}">Hapus</button>
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
    <div class="d-flex justify-content-center">
      <div class="d-flex justify-content-between w-100">
        <div>
          {{ $majors->firstItem() }} sampai {{ $majors->lastItem() }} dari {{ $majors->total() }} hasil
        </div>
        <div>
          {{ $majors->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
    
  </div>
</section>


@endsection

@section('script')
<script>
  $('.btn-hapus').click(function(e) {
    e.preventDefault(); 
    
    var form = $(this).closest('form');
    var majorName = $(this).data('name');

    Swal.fire({
      title: `Hapus "${majorName}"?`,
      text: "Apakah Anda yakin ingin menghapus jurusan ini?",
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