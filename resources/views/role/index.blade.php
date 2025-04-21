@extends('layouts.admin-layout')
@extends('layouts.main')
@section('page-title', 'Role')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Role List</h3>
      <a href="{{ route('role.create') }}" class="btn btn-primary">Add Role</a>
    </div>


    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($roles as $role)
          <tr>
            <td>{{ $roles->firstItem() + $loop->iteration - 1 }}</td>
            <td>{{ $role->name }}</td>
            <td>
              <span class="badge {{ $role->is_active == 1 ? 'bg-success' : 'bg-secondary' }}">
              {{ $role->is_active == 1 ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td>
              <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('role.destroy', $role->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $role->name }}">Hapus</button>
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
          {{ $roles->firstItem() }} sampai {{ $roles->lastItem() }} dari {{ $roles->total() }} hasil
        </div>
        <div>
          {{ $roles->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    var roleName = $(this).data('name');

    Swal.fire({
      title: `Delete "${roleName}"?`,
      text: "Are you sure you want to delete this role?",
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