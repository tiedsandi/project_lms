@extends('layouts.admin-layout')
@extends('layouts.main')
@section('page-title', 'user')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>user List</h3>
      <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah user</a>
    </div>


    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr>
            <td>{{ $users->firstItem() + $loop->iteration - 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->userRoles[0]->role->name }}</td>
            
            <td>
              <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $user->name }}">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">Data kosong.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
      {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    
  </div>
</section>
@endsection

@section('script')
<script>
  $('.btn-hapus').click(function(e) {
    e.preventDefault(); 
    
    var form = $(this).closest('form');
    var userName = $(this).data('name');

    Swal.fire({
      title: `Delete "${userName}"?`,
      text: "Are you sure you want to delete this user?",
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
