<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Easy Cleaner</title>
  @include('layouts.partials.vite-tailwind')
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-primary text-accent font-sans antialiased">

<nav class="navbar">
  <div class="container nav-flex">

    <!-- LOGO -->
    <div class="logo">
      <a href="{{ url('/') }}">
        <img src="{{ asset('assets/img/logoez.png') }}" class="logo-img" alt="">
      </a>
    </div>

    <button
      class="nav-toggle"
      type="button"
      aria-label="Buka menu navigasi"
      aria-expanded="false"
      aria-controls="site-navigation"
    >
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- MENU + CTA FLEX -->
    <div class="nav-right" id="site-navigation">
      <ul class="nav-links">
            <li>
      <a href="{{ url('/') }}">
        <i class="fa-solid fa-house"></i> Home
      </a>
    </li>
        <li>
          <a href="{{ route('user.services.index') }}">
            <i class="fa-solid fa-bag-shopping"></i> Layanan
          </a>
        </li>
        <li>
      <a href="{{ url('/video-review') }}">
            <i class="fa-solid fa-circle-play"></i> Galery
          </a>
        </li>
        <li>
          <a href="{{ route('login') }}">
            <i class="fa-solid fa-user"></i> Login
          </a>
        </li>


      </ul>

      <!-- CTA -->
      <a href="https://wa.me/6281213133421" class="btn btn-orange">
        <i class="fa-brands fa-whatsapp"></i> Pesan Sekarang
      </a>
    </div>

  </div>
</nav>


<!-- CONTENT -->
<main class="pt-28">
  @yield('content')
</main>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-container">

    <div class="footer-branding">
      <h2>Eazy Cleaner</h2>
      <p>
        Professional cleaning service terpercaya dengan kualitas terbaik
        dan pelayanan maksimal untuk kebutuhan Anda.
      </p>
    </div>

    <div class="footer-bottom">
      © {{ date('Y') }} Eazy Cleaner. All rights reserved.
      <br>
      Developed by <span>EazyCleanCenter Corps</span>
    </div>

  </div>
</footer>
<script>
  (() => {
    const navToggle = document.querySelector('.nav-toggle');
    const navPanel = document.querySelector('.nav-right');

    if (!navToggle || !navPanel) {
      return;
    }

    const syncNavState = (isOpen) => {
      navPanel.classList.toggle('is-open', isOpen);
      navToggle.classList.toggle('is-open', isOpen);
      navToggle.setAttribute('aria-expanded', String(isOpen));
      document.body.classList.toggle('nav-open', isOpen);
    };

    navToggle.addEventListener('click', () => {
      syncNavState(!navPanel.classList.contains('is-open'));
    });

    navPanel.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => syncNavState(false));
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth > 900) {
        syncNavState(false);
      }
    });
  })();
</script>
@stack('scripts')
</body>
</html>
