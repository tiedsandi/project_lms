@extends('layouts.admin-layout')

@section('page-title', 'Murid')

@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Daftar Murid</h3>
      <a href="{{ route('murid.create') }}" class="btn btn-primary">Tambah Murid</a>
    </div>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Foto</th>
          <th>Nama</th>
          <th>Major</th>
          <th>Telepon</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($students as $student)
          <tr>
            <td>{{ $students->firstItem() + $loop->index }}</td>
            <td>
              @if ($student->photo)
                <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->user->name ?? '-' }}" width="50" height="50" class="rounded-circle" style="object-fit: cover;">
              @else
                <span class="text-muted">Tidak ada foto</span>
              @endif
            </td>
            <td>{{ $student->user->name ?? '-' }}</td>
            <td>{{ $student->major->name ?? '-' }}</td>
            <td>{{ $student->phone ?? '-' }}</td>
            <td>
              @if (!is_null($student->is_active))
                @if ($student->is_active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Nonaktif</span>
                @endif
              @else
                <span class="badge bg-warning">-</span>
              @endif
            </td>
            <td>
              <a href="{{ route('murid.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('murid.destroy', $student->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $student->user->name ?? 'Murid' }}">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">Data murid kosong.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="d-flex justify-content-center">
      {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@endsection

@section('script')
<script>
  $(document).on('click', '.btn-hapus', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var studentName = $(this).data('name');

    Swal.fire({
      title: `Hapus "${studentName}"?`,
      text: "Apakah Anda yakin ingin menghapus murid ini?",
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
