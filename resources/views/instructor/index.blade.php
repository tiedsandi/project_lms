@extends('layouts.admin-layout') {{-- Pilih salah satu saja --}}

@section('page-title', 'Instruktor')

@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Instruktur List</h3>
      <a href="{{ route('instructor.create') }}" class="btn btn-primary">Tambah Instruktur</a>
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
        @forelse ($instructors as $instructor)
          <tr>
            <td>{{ $instructors->firstItem() + $loop->index }}</td>
            <td>
              @if ($instructor->photo)
                <img src="{{ asset('storage/' . $instructor->photo) }}" alt="{{ $instructor->title }}" width="50" height="50" class="rounded-circle" style="object-fit: cover;">
              @else
                <span class="text-muted">No photo</span>
              @endif
            </td>
            <td>{{ $instructor->title }}</td>
            <td>{{ $instructor->major->name ?? '-' }}</td> {{-- Pastikan major punya 'name' --}}
            <td>{{ $instructor->phone ?? '-' }}</td>
            <td>
              @if (!is_null($instructor->is_active))
                @if ($instructor->is_active)
                  <span class="badge bg-success">Active</span>
                @else
                  <span class="badge bg-secondary">Inactive</span>
                @endif
              @else
                <span class="badge bg-warning">-</span>
              @endif
            </td>
            <td>
              <a href="{{ route('instructor.edit', $instructor->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('instructor.destroy', $instructor->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $instructor->title }}">Delete</button>
                </form>
            </td>
          </tr>
        @empty 
          <tr>
            <td colspan="7" class="text-center">Data kosong.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="d-flex justify-content-center">
      {{ $instructors->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@endsection

@section('script')
<script>
  $(document).on('click', '.btn-hapus', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var instructorName = $(this).data('name');

    Swal.fire({
      title: `Delete "${instructorName}"?`,
      text: "Are you sure you want to delete this instructor?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
</script>
@endsection
