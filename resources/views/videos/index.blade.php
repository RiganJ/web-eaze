@extends('layouts.user')

@section('content')

{{-- ================= HERO ================= --}}
<section class="video-hero">
  <div class="container">
    <h1>Video Review & Proses Kerja</h1>
    <p>Lihat langsung kualitas layanan kami dari proses nyata</p>
  </div>
</section>

{{-- ================= VIDEO GRID ================= --}}
<section class="video-gallery">
  <div class="container">

    @foreach($videos as $category => $categoryVideos)

      <div class="category-section">
        <h2 class="category-title">{{ $category }}</h2>

        <div class="video-grid">
          @foreach($categoryVideos as $index => $video)
          <div class="video-card {{ $index >= 5 ? 'hidden-video d-none' : '' }}">

            <div class="video-thumb"
                 onclick="openVideo('{{ asset($video->video_path) }}')">

              <img src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}">

              <div class="play-overlay">
                <i class="fa-solid fa-play"></i>
              </div>
            </div>

            <div class="video-info">
              <p>{{ $video->description }}</p>
            </div>

          </div>
          @endforeach
        </div>

        {{-- Tombol Selengkapnya --}}
        @if($categoryVideos->count() > 5)
        <div class="see-more-wrapper">
          <button class="see-more-btn" onclick="toggleVideos(this)">
            Selengkapnya
          </button>
        </div>
        @endif

      </div>

    @endforeach

  </div>
</section>

{{-- ================= MODAL ================= --}}
<div class="video-modal" id="videoModal">
  <div class="modal-overlay" onclick="closeVideo()"></div>

  <div class="modal-content">
    <button class="close-btn" onclick="closeVideo()">
      <i class="fa-solid fa-xmark"></i>
    </button>

    <video
      id="modalVideo"
      controls
      playsinline
      preload="auto"
      style="width:100%; display:block;"
    ></video>

  </div>
</div>

@endsection

@push('scripts')
<script>

function openVideo(src) {

  const modal = document.getElementById('videoModal');
  const video = document.getElementById('modalVideo');

  video.pause();
  video.currentTime = 0;
  video.src = src;

  modal.classList.add('active');

  video.play().catch(err => {
    console.log("Play error:", err);
  });
}

function closeVideo() {

  const modal = document.getElementById('videoModal');
  const video = document.getElementById('modalVideo');

  video.pause();
  video.currentTime = 0;
  video.src = '';

  modal.classList.remove('active');
}


// ================= TOGGLE SELENGKAPNYA =================

function toggleVideos(button) {

  const section = button.closest('.category-section');
  const hiddenVideos = section.querySelectorAll('.hidden-video');

  hiddenVideos.forEach(video => {
    video.classList.toggle('d-none');
  });

  if (button.innerText === "Selengkapnya") {
    button.innerText = "Tampilkan Lebih Sedikit";
  } else {
    button.innerText = "Selengkapnya";
  }
}

</script>
@endpush
