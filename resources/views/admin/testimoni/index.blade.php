@extends('layouts.cms')

@section('title','Testimoni')
@section('page-title','Kelola Testimoni')

@section('content')

<div class="order-wrapper">
  <div class="order-card">

<div class="order-header" style="display:flex;justify-content:space-between;align-items:center;">
  <div>
    <h4>Testimoni</h4>
    <small>Moderasi testimoni customer</small>
  </div>

  <a href="/admin/testimoni/create" class="btn edit">
    + Tambah Testimoni
  </a>
</div>

    <table class="order-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Rating</th>
          <th>Media</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        @foreach($testimonials as $t)
        <tr>
          <td>{{ $t->name }}</td>

          <td>
            @for($i=1;$i<=$t->rating;$i++)
              ⭐
            @endfor
          </td>

<td>
@if($t->media)
    @if($t->media_type == 'image')
        <img src="{{ Storage::url($t->media) }}" width="60" alt="Foto Testimoni">
    @elseif($t->media_type == 'video')
        <video width="120" controls>
            <source src="{{ Storage::url($t->media) }}" type="video/mp4">
            Browser Anda tidak mendukung video
        </video>
    @endif
@endif
</td>



          <td>{{ ucfirst($t->status) }}</td>

          <td>
            @if($t->status == 'pending')
              <form method="POST" action="/admin/testimoni/{{ $t->id }}/approve" style="display:inline">
                @csrf
                <button class="btn edit">Approve</button>
              </form>

              <form method="POST" action="/admin/testimoni/{{ $t->id }}/reject" style="display:inline">
                @csrf
                <button class="btn delete">Reject</button>
              </form>
            @endif
          </td>
          <td>
  <a href="/admin/testimoni/{{ $t->id }}/edit" class="btn edit">Edit</a>

<form method="POST" action="/admin/testimoni/{{ $t->id }}" style="display:inline" class="form-delete">
    @csrf
    @method('DELETE')
    <button class="btn delete">Hapus</button>
  </form>
</td>

        </tr>
        @endforeach
      </tbody>
    </table>

    <div style="margin-top:24px">
      {{ $testimonials->links() }}
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
