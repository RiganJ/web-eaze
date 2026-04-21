<aside class="cms-sidebar">
  <div class="logo">
    <i class="fa-solid fa-broom-ball"></i>
  </div>

  <nav class="sidebar-nav">

    @php
        $role = Auth::user()->role;
    @endphp

    {{-- ---------------- ADMIN LAUNDRY ---------------- --}}
    @if($role === 'admin_laundry')
      <a href="{{ url('admin/laundry/dashboard') }}"
         class="{{ request()->is('admin/laundry/dashboard*') ? 'active' : '' }}"
         title="Dashboard">
        <i class="fa-solid fa-chart-line"></i>
      </a>

      <a href="{{ url('admin/laundry/orders') }}"
         class="{{ request()->is('admin/laundry/orders*') ? 'active' : '' }}"
         title="Pesanan">
        <i class="fa-solid fa-spinner"></i>
      </a>

<form method="POST" action="{{ route('logout') }}" class="logout-form" id="logoutForm">
    @csrf
    <button type="button" id="logoutButton" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </button>
</form>

    {{-- ---------------- ADMIN HOMECLEAN ---------------- --}}
    @elseif($role === 'admin_homeclean')
      <a href="{{ url('admin/homecleaning/dashboard') }}"
         class="{{ request()->is('admin/homecleaning/dashboard*') ? 'active' : '' }}"
         title="Dashboard">
        <i class="fa-solid fa-chart-line"></i>
      </a>

      <a href="{{ url('admin/homecleaning/orders') }}"
         class="{{ request()->is('admin/homecleaning/orders*') ? 'active' : '' }}"
         title="Pesanan">
        <i class="fa-solid fa-spinner"></i>
      </a>

<form method="POST" action="{{ route('logout') }}" class="logout-form" id="logoutForm">
    @csrf
    <button type="button" id="logoutButton" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </button>
</form>

    {{-- ---------------- ADMIN DETAILING ---------------- --}}
    @elseif($role === 'admin_detailing')
      <a href="{{ url('admin/detailing/dashboard') }}"
         class="{{ request()->is('admin/detailing/dashboard*') ? 'active' : '' }}"
         title="Dashboard">
        <i class="fa-solid fa-chart-line"></i>
      </a>

      <a href="{{ url('admin/detailing/orders') }}"
         class="{{ request()->is('admin/detailing/orders*') ? 'active' : '' }}"
         title="Pesanan">
        <i class="fa-solid fa-spinner"></i>
      </a>

<form method="POST" action="{{ route('logout') }}" class="logout-form" id="logoutForm">
    @csrf
    <button type="button" id="logoutButton" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </button>
</form>

    {{-- ---------------- ADMIN CAR WASH ---------------- --}}
    @elseif($role === 'admin_carwash')
      <a href="{{ url('admin/carwash/dashboard') }}"
         class="{{ request()->is('admin/carwash/dashboard*') ? 'active' : '' }}"
         title="Dashboard">
        <i class="fa-solid fa-chart-line"></i>
      </a>

      <a href="{{ url('admin/carwash/orders') }}"
         class="{{ request()->is('admin/carwash/orders*') ? 'active' : '' }}"
         title="Pesanan">
        <i class="fa-solid fa-spinner"></i>
      </a>

<form method="POST" action="{{ route('logout') }}" class="logout-form" id="logoutForm">
    @csrf
    <button type="button" id="logoutButton" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </button>
</form>
      {{-- ---------------- ADMIN CUCIAN MOTOR ---------------- --}}
@elseif($role === 'admin_cucianmotor')
  <a href="{{ url('admin/cucianmotor/dashboard') }}"
     class="{{ request()->is('admin/cucianmotor/dashboard*') ? 'active' : '' }}"
     title="Dashboard">
    <i class="fa-solid fa-chart-line"></i>
  </a>

  <a href="{{ url('admin/cucianmotor/orders') }}"
     class="{{ request()->is('admin/cucianmotor/orders*') ? 'active' : '' }}"
     title="Pesanan">
    <i class="fa-solid fa-spinner"></i>
  </a>

<form method="POST" action="{{ route('logout') }}" class="logout-form" id="logoutForm">
    @csrf
    <button type="button" id="logoutButton" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </button>
</form>

  {{-- ---------------- ADMIN KARSOBED ---------------- --}}
@elseif($role === 'admin_karsobed')
  <a href="{{ url('admin/karsobed/dashboard') }}"
     class="{{ request()->is('admin/karsobed/dashboard*') ? 'active' : '' }}"
     title="Dashboard">
    <i class="fa-solid fa-chart-line"></i>
  </a>

  <a href="{{ url('admin/karsobed/orders') }}"
     class="{{ request()->is('admin/karsobed/orders*') ? 'active' : '' }}"
     title="Pesanan">
    <i class="fa-solid fa-spinner"></i>
  </a>

  <form method="POST" action="{{ route('logout') }}" class="logout-form">
    @csrf
    <button type="submit" title="Logout">
      <i class="fa-solid fa-right-from-bracket"></i>
    </button>
  </form>

  @elseif($role === 'admin_polish')
  <a href="{{ url('admin/polish/dashboard') }}"
     class="{{ request()->is('admin/polish/dashboard*') ? 'active' : '' }}"
     title="Dashboard">
    <i class="fa-solid fa-chart-line"></i>
  </a>

  <a href="{{ url('admin/polish/orders') }}"
     class="{{ request()->is('admin/polish/orders*') ? 'active' : '' }}"
     title="Pesanan">
    <i class="fa-solid fa-spinner"></i>
  </a>

  <form method="POST" action="{{ route('logout') }}" class="logout-form">
    @csrf
    <button type="submit" title="Logout">
      <i class="fa-solid fa-right-from-bracket"></i>
    </button>
  </form>



    {{-- ---------------- DEFAULT ADMIN / SUPERADMIN ---------------- --}}
    @else
      <a href="{{ url('admin/dashboard') }}"
         class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}"
         title="Dashboard">
        <i class="fa-solid fa-chart-line"></i>
      </a>

      <a href="{{ url('admin/layanan') }}"
         class="{{ request()->is('admin/layanan*') ? 'active' : '' }}"
         title="Layanan">
        <i class="fa-solid fa-layer-group"></i>
      </a>

      @if($role === 'super_admin')
      <a href="{{ route('admin.layanan.prices') }}"
         class="{{ request()->is('admin/layanan/harga*') ? 'active' : '' }}"
         title="Harga Layanan">
        <i class="fa-solid fa-tags"></i>
      </a>
      @endif

      <a href="{{ url('admin/users') }}"
         class="{{ request()->is('admin/users*') ? 'active' : '' }}"
         title="Pengguna">
        <i class="fa-solid fa-users"></i>
      </a>

      <a href="{{ url('admin/laporan-keuangan') }}"
         class="{{ request()->is('admin/laporan-keuangan*') ? 'active' : '' }}"
         title="Keuangan">
        <i class="fa-solid fa-wallet"></i>
      </a>

      <a href="{{ url('admin/testimoni') }}"
         class="{{ request()->is('admin/testimoni*') ? 'active' : '' }}"
         title="Testimoni">
        <i class="fa-solid fa-comment-dots"></i>
      </a>
            <a href="{{ url('admin/video') }}"
         class="{{ request()->is('admin/video*') ? 'active' : '' }}"
         title="Testimoni">
        <i class="fa-solid fa-circle-play"></i>
      </a>


<form method="POST" action="{{ route('logout') }}" class="logout-form" id="logoutForm">
    @csrf
    <button type="button" id="logoutButton" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i> 
    </button>
</form>
    @endif

  </nav>
</aside>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('logoutButton').addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah form submit otomatis

        // Menampilkan SweetAlert konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin ingin keluar?',
            text: "Anda akan diarahkan ke halaman login!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika konfirmasi diterima, form logout akan disubmit
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>
