@extends('layouts.cms')

@section('title','Tambah Video Review')
@section('page-title','Tambah Video Review')

@section('content')

<div class="order-wrapper">
  <div class="order-card">

    <div class="order-header">
      <div>
        <h4>Tambah Video Review</h4>
        <small>Upload video promosi atau review layanan</small>
      </div>
    </div>

    <div class="form-card">
      <form method="POST" action="/admin/video" enctype="multipart/form-data">
        @csrf

<select name="title" required>
    <option value="">-- Pilih Kategori --</option>
    <option value="Laundry">Laundry</option>
    <option value="Cucian Motor">Cucian Motor</option>
    <option value="Carwash">Carwash</option>
    <option value="Homecleaning">Homecleaning</option>
</select>


        <textarea 
          name="description" 
          placeholder="Deskripsi singkat video (opsional)"
        ></textarea>
        
        <label class="label-colored">Thumbnail</label>
        <input 
          type="file" 
          name="thumbnail" 
          accept="image/*" 
          id="thumbInput"
          required
        >
        <img id="thumbPreview" style="max-width:140px;display:none;margin-bottom:10px">

        <label class="label-colored">Video (MP4)</label>
        <input 
          type="file" 
          name="video" 
          accept="video/mp4" 
          id="videoInput"
          required
        >
        <video id="videoPreview" width="200" controls style="display:none"></video>

        <label class="label-colored">Status</label>
        <select name="is_active">
          <option value="1">Aktif</option>
          <option value="0">Nonaktif</option>
        </select>

        <button class="btn edit">
          <i class="fa-solid fa-upload"></i> Upload Video
        </button>
      </form>
    </div>

  </div>
</div>

<script>
document.getElementById('thumbInput').addEventListener('change', e => {
  const file = e.target.files[0];
  if(!file) return;
  const img = document.getElementById('thumbPreview');
  img.src = URL.createObjectURL(file);
  img.style.display = 'block';
});

document.getElementById('videoInput').addEventListener('change', e => {
  const file = e.target.files[0];
  if(!file) return;
  const video = document.getElementById('videoPreview');
  video.src = URL.createObjectURL(file);
  video.style.display = 'block';
});
</script>

@endsection
