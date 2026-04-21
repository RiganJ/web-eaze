@extends('layouts.user')

@php
function detailingIcon($category) {
    $c = strtolower($category);

    return match (true) {
        // GENERAL
        str_contains($c, 'detailing')           => 'fa-spray-can-sparkles',
        str_contains($c, 'cleaning')            => 'fa-broom',

        // HOME
        str_contains($c, 'karpet')               => 'fa-border-all',
        str_contains($c, 'kasur'),
        str_contains($c, 'spring')               => 'fa-bed',
        str_contains($c, 'sofa')                 => 'fa-couch',
        str_contains($c, 'kaca')                 => 'fa-window-maximize',
        str_contains($c, 'kristalisasi')         => 'fa-gem',
        str_contains($c, 'kamar mandi')          => 'fa-shower',
        str_contains($c, 'lantai')               => 'fa-layer-group',
        str_contains($c, 'aquarium')             => 'fa-fish',

        // VEHICLE
        str_contains($c, 'mobil')                => 'fa-car-side',
        str_contains($c, 'motor')                => 'fa-motorcycle',

        default                                  => 'fa-spray-can-sparkles',
    };
}
@endphp

@section('content')

{{-- HERO --}}
<section class="service-hero">
  <div class="container">
    <span class="hero-badge">
      <i class="fa-solid fa-spray-can-sparkles"></i>
      Detailing & Cleaning Services
    </span>

    <h1>
      Solusi Kebersihan <br>
      <span>Rumah & Kendaraan</span>
    </h1>

    <p>
      Layanan detailing & cleaning profesional untuk rumah, mobil, dan motor
    </p>
  </div>
</section>

{{-- CATEGORY LIST --}}
<section class="service-list">
  <div class="container service-grid">

    @foreach ($services as $category => $items)
      <div class="service-card category-card"
           onclick="openCategoryModal('{{ $category }}')">

        <div class="icon">
          <i class="fa-solid {{ detailingIcon($category) }}"></i>
        </div>

        <h3>{{ $category }}</h3>
        <p>{{ $items->count() }} layanan tersedia</p>

        <span class="btn btn-orange btn-sm">
          Lihat Detail
        </span>

      </div>
    @endforeach

  </div>
</section>

{{-- MODAL --}}
<div class="service-modal" id="categoryModal">
  <div class="modal-box modal-modern">

    <div class="modal-header">
      <div>
        <h2 id="modalCategoryTitle"></h2>
        <p class="modal-subtitle">
          Pilih layanan detailing & cleaning sesuai kebutuhan Anda
        </p>
      </div>

      <button class="modal-close" onclick="closeCategoryModal()">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div class="modal-body">
      <div class="modal-grid" id="modalServices"></div>
    </div>

  </div>
</div>

{{-- SCRIPT --}}
<script>
const servicesData = @json($services);

function getDetailingIcon(category) {
  category = category.toLowerCase();

  if (category.includes('mobil')) return 'fa-car-side';
  if (category.includes('motor')) return 'fa-motorcycle';
  if (category.includes('karpet')) return 'fa-border-all';
  if (category.includes('kasur') || category.includes('spring')) return 'fa-bed';
  if (category.includes('sofa')) return 'fa-couch';
  if (category.includes('kaca')) return 'fa-window-maximize';
  if (category.includes('kristalisasi')) return 'fa-gem';
  if (category.includes('kamar mandi')) return 'fa-shower';
  if (category.includes('lantai')) return 'fa-layer-group';
  if (category.includes('aquarium')) return 'fa-fish';

  return 'fa-spray-can-sparkles';
}

function openCategoryModal(category) {
  const modal   = document.getElementById('categoryModal');
  const title   = document.getElementById('modalCategoryTitle');
  const content = document.getElementById('modalServices');

  title.innerHTML =
    `<i class="fa-solid ${getDetailingIcon(category)}"></i> ${category}`;

  content.innerHTML = '';

  servicesData[category].forEach(item => {
    content.innerHTML += `
      <div class="service-card modal-card">

        <div class="icon">
          <i class="fa-solid ${getDetailingIcon(category)}"></i>
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
          href="https://wa.me/6285117803421?text=${encodeURIComponent(
            'Halo, saya ingin pesan layanan ' + item.name
          )}"
          target="_blank"
          class="btn btn-orange btn-sm full"
        >
          <i class="fa-brands fa-whatsapp"></i> Pesan Sekarang
        </a>

      </div>
    `;
  });

  modal.classList.add('active');
}

function closeCategoryModal() {
  document.getElementById('categoryModal').classList.remove('active');
}
</script>

@endsection
