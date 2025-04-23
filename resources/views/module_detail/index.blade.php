@extends('layouts.admin-layout')
@extends('layouts.main')

@section('page-title', 'Learning Module Details')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Learning Module Detail List</h3>
      @if(request('module_id'))
        <a href="{{ route('detail_module.create', ['module' => request('module_id')]) }}" class="btn btn-primary">
            Tambah Detail Modul
        </a>
      @endif   
    </div>

    <form method="GET" action="{{ route('detail_module.index') }}" class="d-flex mb-3">
      <select name="module_id" class="form-select me-2">
        <option value="">Pilih Modul</option>
        @foreach ($learning_module as $module)
          <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
            {{ $module->name }}
          </option>
        @endforeach
      </select>
      
      <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama File</th>
          <th>File</th>
          <th>Link Referensi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($detail_module as $detail)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $detail->file_name }}</td>
            <td>
              @if ($detail->file)
                <a href="{{ asset('storage/' . $detail->file) }}" target="_blank" class="btn btn-sm btn-info">Lihat File</a>
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
            <td>
              <a href="{{ route('detail_module.edit', $detail->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('detail_module.destroy', $detail->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $detail->file_name }}">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">Data tidak ada.</td>
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
    var fileName = $(this).data('name');

    Swal.fire({
      title: `Hapus "${fileName}"?`,
      text: "Apakah anda yakin ingin menghapus detail modul ini?",
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
