@extends('layouts.user')
@php
function LaundryIcon($category) {
    $c = strtolower($category);

    return match (true) {
        str_contains($c, 'laundry')         => 'fa-shirt',
        str_contains($c, 'karpet')         => 'fa-border-all',
        str_contains($c, 'kasur')          => 'fa-bed',
        str_contains($c, 'spring')         => 'fa-bed',
        str_contains($c, 'sofa')           => 'fa-couch',
        str_contains($c, 'vacum'),
        str_contains($c, 'vacuum')         => 'fa-broom',
        str_contains($c, 'kaca')           => 'fa-window-maximize',
        str_contains($c, 'kristalisasi')   => 'fa-gem',
        str_contains($c, 'kamar mandi')    => 'fa-shower',
        str_contains($c, 'lantai')         => 'fa-layer-group',
        str_contains($c, 'aquarium')       => 'fa-fish',
        default                            => 'fa-broom',
    };
}
@endphp
@section('content')

{{-- HERO --}}
<section class="service-hero">
  <div class="container">
    <span class="hero-badge">
      <i class="fa-solid fa-shirt"></i> Layanan Laundry
    </span>

    <h1>Laundry Bersih <br><span>Tanpa Ribet</span></h1>
    <p>Laundry kiloan & satuan, jemput dan antar ke rumah Anda.</p>
  </div>
</section>

{{-- LIST --}}
<section class="service-list">
  <div class="container service-grid">

    @foreach ($services as $category => $items)
      <div class="service-card category-card"
           onclick="openCategoryModal('{{ $category }}')">

        <div class="icon">
          <i class="fa-solid {{ LaundryIcon($category) }}"></i>
        </div>

        <h3>{{ $category }}</h3>
        <p>{{ $items->count() }} layanan tersedia</p>

        <span class="btn btn-orange btn-sm">
          Lihat Layanan
        </span>

      </div>
    @endforeach

  </div>
</section>

<div class="service-modal" id="categoryModal">
  <div class="modal-box modal-modern">

    {{-- HEADER --}}
    <div class="modal-header">
      <div>
        <h2 id="modalCategoryTitle"></h2>
        <p class="modal-subtitle">Pilih layanan sesuai kebutuhan Anda</p>
      </div>

      <button class="modal-close" onclick="closeCategoryModal()">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    {{-- BODY --}}
    <div class="modal-body">
      <div class="modal-grid" id="modalServices"></div>
    </div>

  </div>
</div>

{{-- SCRIPT --}}
<script>
const servicesData = @json($services);

// Fungsi untuk memilih icon sesuai kategori
function getHomeCleaningIcon(category) {
  category = category.toLowerCase();
  if (category.includes('laundry')) return 'fa-shirt';
  if (category.includes('karpet')) return 'fa-border-all';
  if (category.includes('kasur') || category.includes('spring')) return 'fa-bed';
  if (category.includes('sofa')) return 'fa-couch';
  if (category.includes('vacum') || category.includes('vacuum')) return 'fa-broom';
  if (category.includes('kaca')) return 'fa-window-maximize';
  if (category.includes('kristalisasi')) return 'fa-gem';
  if (category.includes('kamar mandi')) return 'fa-shower';
  if (category.includes('lantai')) return 'fa-layer-group';
  if (category.includes('aquarium')) return 'fa-fish';

  return 'fa-broom';
}

// Fungsi untuk membuka modal
function openCategoryModal(category) {
  const modal   = document.getElementById('categoryModal');
  const title   = document.getElementById('modalCategoryTitle');
  const content = document.getElementById('modalServices');

  title.innerHTML = `<i class="fa-solid ${getHomeCleaningIcon(category)}"></i> ${category}`;
  content.innerHTML = '';

  if (servicesData[category]) {
    servicesData[category].forEach(item => {
      content.innerHTML += `
        <div class="service-card modal-card">
          <div class="icon">
            <i class="fa-solid ${getHomeCleaningIcon(category)}"></i>
          </div>

          <h4>
            ${item.name}
            ${item.type ? `<small>(${item.type})</small>` : ''}
          </h4>

          <p>${item.unit}</p>

          <div class="price">
            Rp ${Number(item.price).toLocaleString('id-ID')}
          </div>

          <a
            href="https://wa.me/6281213133421?text=${encodeURIComponent(
              'Halo, saya ingin pesan ' + item.name + (item.type ? ' ' + item.type : '')
            )}"
            target="_blank"
            class="btn btn-orange btn-sm full"
          >
            <i class="fa-brands fa-whatsapp"></i> Pesan
          </a>
        </div>
      `;
    });
  } else {
    content.innerHTML = '<p>Layanan tidak tersedia untuk kategori ini.</p>';
  }

  modal.classList.add('active');
}

function closeCategoryModal() {
  document.getElementById('categoryModal').classList.remove('active');
}
</script>


@endsection
