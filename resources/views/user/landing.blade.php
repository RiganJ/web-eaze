@extends('layouts.user')

@section('content')

<section class="hero">
  <div class="container hero-grid">

    <!-- TEKS HERO -->
    <div class="hero-text">


      <h1>
        Solusi Bersih <br>
        <span>Tanpa Ribet</span>
      </h1>

      <p>
        Layanan laundry, cuci kendaraan, dan pembersihan rumah.
        <br>Kami datang langsung ke tempat Anda.
      </p>

      <!-- INFO LOKASI & JAM OPERASIONAL -->
      <div class="hero-info">
        <p>
          <i class="fa-solid fa-location-dot"></i>
          Jl. Soekarno Hatta, Garegeh, Kec. Mandiangin Koto Selayan,<br>
          Kota Bukittinggi, Sumatera Barat 26117
        </p>

        <p>
          <i class="fa-solid fa-clock"></i>
          Jam Operasional: <strong>08.00 – 22.00</strong>
        </p>
      </div>

      <!-- TOMBOL AKSI -->
      <div class="hero-action">
        <a href="https://wa.me/6281213133421" class="btn btn-orange btn-lg">
          <i class="fa-brands fa-whatsapp"></i>
          Pesan via WhatsApp
        </a>
      </div>
    </div>

    <!-- KARTU LAYANAN -->
    <div class="hero-illustration">

      <div class="illus-card">
        <i class="fa-solid fa-shirt"></i>
        <span>Laundry Service</span>
      </div>

      <div class="illus-card">
        <i class="fa-solid fa-car"></i>
        <span>Car Wash</span>
      </div>

      <div class="illus-card">
        <i class="fa-solid fa-motorcycle"></i>
        <span>Cuci Motor</span>
      </div>

      <div class="illus-card">
        <i class="fa-solid fa-house"></i>
        <span>Home Cleaning</span>
      </div>

    </div>

  </div>
</section>



<section id="layanan" class="services">
  <div class="container">

    <h2 class="section-title">Layanan Kami</h2>

    <div class="service-grid">

      <div class="service-card">
 <div class="icon"><i class="fa-solid fa-shirt"></i></div>
        <h3>Laundry</h3>
        <p>Jemput & Antar</p>
        <span class="price">Mulai Rp 8.000 / Kg</span>
        <a href="{{ route('user.services.index') }}" class="btn btn-white">
          <i class="fa-solid fa-shirt"></i> Cek Layanan
        </a>
      </div>

      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-car"></i></div>
        <h3>Cuci Mobil</h3>
        <p>Datang ke Rumah</p>
        <span class="price">Profesional</span>
        <a href="{{ route('user.services.index') }}" class="btn btn-white">
          <i class="fa-solid fa-car"></i> Cek Layanan
        </a>
      </div>

      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-motorcycle"></i></div>
        <h3>Cuci Motor</h3>
        <p>Di Tempat </p>
        <span class="price">Cepat & Bersih</span>
        <a href="{{ route('user.services.index') }}" class="btn btn-white">
          <i class="fa-solid fa-motorcycle"></i> Cek Layanan
        </a>
      </div>

      <div class="service-card">
        <div class="icon"><i class="fa-solid fa-house-chimney"></i></div>
        <h3>Bersih Rumah</h3>
        <p>Tenaga Ahli</p>
        <span class="price">Solusi Rumah Mengkilau</span>
        <a href="{{ route('user.services.index') }}" class="btn btn-white">
          <i class="fa-solid fa-house-chimney"></i> Layanan
        </a>
      </div>

    </div>
  </div>
</section>


<section class="why">
  <div class="container">

    <div class="why-header">
      <span class="why-badge">
        <i class="fa-solid fa-thumbs-up"></i> Kenapa Pilih Kami
      </span>
      <h2>Alasan Pelanggan<br><span>Mempercayai EasyCleaner</span></h2>
    </div>

    <div class="why-grid">

      <div class="why-card">
        <div class="icon">
          <i class="fa-solid fa-bolt"></i>
        </div>
        <h3>Cepat</h3>
        <p>Respon cepat & pengerjaan efisien</p>
      </div>

      <div class="why-card">
        <div class="icon">
          <i class="fa-solid fa-user-gear"></i>
        </div>
        <h3>Profesional</h3>
        <p>Tim terlatih & berpengalaman</p>
      </div>

      <div class="why-card">
        <div class="icon">
          <i class="fa-solid fa-house"></i>
        </div>
        <h3>Datang ke Rumah</h3>
        <p>Tanpa ribet, kami yang datang</p>
      </div>

      <div class="why-card">
        <div class="icon">
          <i class="fa-solid fa-wallet"></i>
        </div>
        <h3>Harga Transparan</h3>
        <p>Tanpa biaya tersembunyi</p>
      </div>

    </div>
  </div>
</section>


<section class="promo">
  <div class="container">
    <div class="promo-card">
      <h2><i class="fa-solid fa-tags"></i> Promo Spesial</h2>
      <p>Diskon Laundry <b>20%</b> untuk pelanggan baru</p>
    </div>
  </div>
</section>
<section class="testimonials">

  <!-- ================= HEADER ================= -->
<div class="container">
  <h2 class="section-title">
    <i class="fa-solid fa-comments"></i> Testimoni Pelanggan
  </h2>
    <p class="section-subtitle">
      Pengalaman nyata pelanggan yang telah menggunakan layanan kami
    </p>

    <!-- ================= TESTIMONI GRID ================= -->
    <div class="testimonials-grid">
      @foreach($testimonials as $testimonial)
        @if($testimonial->status == 'approved')
          <div class="testimonial-box">

            @if($testimonial->media)
            <div class="testimonial-media">
              <img
                src="{{ asset($testimonial->media) }}"
                alt="{{ $testimonial->name }}"
                class="open-image">
            </div>
            @endif

            <div class="testimonial-content">
              <h4 class="name">{{ $testimonial->name }}</h4>

              <div class="rating">
                @for($i = 0; $i < $testimonial->rating; $i++)
                  <i class="fa-solid fa-star"></i>
                @endfor
              </div>

              <p class="service">{{ $testimonial->service }}</p>
              <p class="message">“{{ $testimonial->message }}”</p>
            </div>

          </div>
        @endif
      @endforeach
    </div>
  </div>
</section>

<!-- ================= FORM SECTION ================= -->
<section class="testimonial-form-section">
<div class="container form-layout">

  <!-- INFO -->
  <div class="form-info">
    <h3>Bagikan Pengalaman Anda</h3>
    <p>
      Testimoni Anda membantu kami meningkatkan kualitas layanan.
      Kami sangat menghargai setiap masukan dari pelanggan.
    </p>

    <div class="info-box">
      <i class="fa-solid fa-location-dot"></i>
      <span>
        Jl. Soekarno Hatta, Garegeh, Kec. Mandiangin Koto Selayan,<br>
        Kota Bukittinggi, Sumatera Barat 26117
      </span>
    </div>

    <!-- MAP -->
    <div class="map-box">
      <iframe
        src="https://www.google.com/maps?q=Jl.%20Soekarno%20Hatta%20Garegeh%20Bukittinggi&output=embed"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>


    <!-- FORM -->
    <div class="testimonial-form-wrapper">

      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('testimoni.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label>Nama</label>
          <input type="text" name="name" placeholder="Nama Anda" required>
        </div>

        <div class="form-group">
          <label>Layanan</label>
          <input type="text" name="service" placeholder="Contoh: Laundry / Cuci Mobil" required>
        </div>

        <div class="form-group">
          <label>Rating</label>
          <select name="rating" required>
            <option value="">Pilih Rating</option>
            @for($i = 5; $i >= 1; $i--)
              <option value="{{ $i }}">{{ str_repeat('⭐', $i) }}</option>
            @endfor
          </select>
        </div>

        <div class="form-group">
          <label>Testimoni</label>
          <textarea name="message" placeholder="Tuliskan pengalaman Anda..." required></textarea>
        </div>

        <div class="form-group">
          <label>Foto (Opsional)</label>
          <input type="file" name="media" accept="image/*" id="mediaInput">
          <img id="mediaPreview">
        </div>

        <button type="submit" class="btn-submit">
          Kirim Testimoni
        </button>
      </form>
    </div>

  </div>
</section>

<!-- ================= IMAGE MODAL ================= -->
<div id="imageModal" class="image-modal">
  <span class="close-modal">&times;</span>
  <img id="modalImage">
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const mediaInput = document.getElementById('mediaInput');
    const mediaPreview = document.getElementById('mediaPreview');
    const mediaPreviewWrapper = document.getElementById('mediaPreviewWrapper');

    // Fungsi untuk menangani perubahan pada input file
    mediaInput.addEventListener('change', function (e) {
        const file = e.target.files[0]; // Ambil file yang dipilih
        if (!file) return; // Jika tidak ada file yang dipilih, keluar

        // Periksa apakah file adalah gambar atau video
        if (file.type.startsWith('image')) {
            // Jika file adalah gambar, tampilkan preview gambar
            const reader = new FileReader();
            reader.onload = function (event) {
                mediaPreview.src = event.target.result;  // Set preview gambar
                mediaPreview.style.display = 'block';    // Tampilkan gambar
                mediaPreviewWrapper.style.display = 'flex'; // Tampilkan wrapper
            };
            reader.readAsDataURL(file);  // Membaca file gambar

        } else if (file.type.startsWith('video')) {
            // Jika file adalah video, tampilkan preview video
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.style.maxWidth = '100%';
            video.style.maxHeight = '150px';
            video.controls = true;
            
            mediaPreviewWrapper.innerHTML = '';  // Bersihkan isi wrapper
            mediaPreviewWrapper.appendChild(video);  // Menambahkan video ke wrapper
            video.style.display = 'block';  // Menampilkan video
        } else {
            // Jika file bukan gambar atau video, sembunyikan preview
            mediaPreview.style.display = 'none';
            mediaPreviewWrapper.style.display = 'none';
        }
    });

    // Validasi file yang dipilih sebelum form disubmit
    document.querySelector('form').addEventListener('submit', function (e) {
        const file = mediaInput.files[0];
        
        if (file) {
            // Periksa ukuran file (maksimal 10MB)
            const maxSize = 10 * 1024 * 1024; // 10MB dalam byte
            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar! Maksimal 10MB.');
                e.preventDefault(); // Cegah pengiriman form
                return;
            }

            // Periksa tipe file (hanya gambar dan video yang diperbolehkan)
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'video/mp4'];
            if (!allowedTypes.includes(file.type)) {
                alert('Tipe file tidak valid! Harus gambar (jpg, png) atau video (mp4).');
                e.preventDefault(); // Cegah pengiriman form
                return;
            }
        }
    });
});
</script>
<script>
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const closeBtn = document.querySelector(".close-modal");

  document.querySelectorAll(".open-image").forEach(img => {
    img.addEventListener("click", () => {
      modal.style.display = "flex";
      modalImg.src = img.src;
    });
  });

  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
</script>

@endsection
