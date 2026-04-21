@extends('layouts.cms')

@section('title','Video Review')
@section('page-title','Kelola Video Review')

@section('content')

<div class="order-wrapper">
  <div class="order-card">

    <div class="order-header" style="display:flex;justify-content:space-between;align-items:center;">
      <div>
        <h4>Video Review</h4>
        <small>Kelola video promosi & review layanan</small>
      </div>

      <a href="/admin/video/create" class="btn edit">
        + Tambah Video
      </a>
    </div>

    <table class="order-table">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Preview</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        @foreach($videos as $v)
        <tr>
          <td>
            <strong>{{ $v->title }}</strong>
            <br>
            <small>{{ Str::limit($v->description, 60) }}</small>
          </td>

          <td>
            <video width="140" controls>
              <source src="{{ asset($v->video_path) }}" type="video/mp4">

              Browser tidak mendukung video
            </video>
          </td>

          <td>
            <span class="badge {{ $v->is_active ? 'success' : 'danger' }}">
              {{ $v->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
          </td>

          <td>
            <a href="/admin/video/{{ $v->id }}/edit" class="btn edit">Edit</a>

<form method="POST" 
      action="{{ route('admin.video.destroy', $v->id) }}" 
      style="display:inline" 
      class="form-delete">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn delete">
        Hapus
    </button>
</form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div style="margin-top:24px">
      {{ $videos->links() }}
    </div>

  </div>
</div>
<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endsection
