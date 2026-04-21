@extends('layouts.cms')

@section('title','Tambah Testimoni')
@section('page-title','Tambah Testimoni')

@section('content')

<div class="order-wrapper">
  <div class="order-card">

    <div class="order-header">
      <div>
        <h4>Tambah Testimoni</h4>
        <small>Input testimoni manual oleh admin</small>
      </div>
    </div>

    <div class="form-card">
      <form method="POST" action="/admin/testimoni" enctype="multipart/form-data">
        @csrf

        <input name="name" placeholder="Nama customer">

        <input name="service" placeholder="Layanan">

        <textarea name="message" placeholder="Tulis testimoni customer..."></textarea>

        <select name="rating">
          @for($i = 5; $i >= 1; $i--)
            <option value="{{ $i }}">{{ str_repeat('⭐', $i) }}</option>
          @endfor
        </select>

        <input type="file" name="media" id="mediaInput" accept="image/*,video/mp4">

<img id="mediaPreview" style="max-width:120px; display:none;">
<video id="videoPreview" width="120" controls style="display:none;"></video>

        <button class="btn edit">
          <i class="fa-solid fa-save"></i> Simpan Testimoni
        </button>
      </form>
    </div>

  </div>
</div>
<script>
document.getElementById('mediaInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const img = document.getElementById('mediaPreview');
    const video = document.getElementById('videoPreview');

    if(file.type.startsWith('image')) {
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
        video.style.display = 'none';
    } else if(file.type.startsWith('video')) {
        video.src = URL.createObjectURL(file);
        video.style.display = 'block';
        img.style.display = 'none';
    }
});
</script>
@endsection
