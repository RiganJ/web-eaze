@extends('layouts.user')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="service-hero">
  <div class="container">
    <span class="hero-badge">
      <i class="fa-solid fa-shirt"></i> Layanan
    </span>
    <h1>Layanan Profesional <br><span>Untuk Rumah Anda</span></h1>
    <p>Pilih layanan sesuai kebutuhan Anda.</p>
  </div>
</section>

{{-- ===================== CATEGORY LIST ===================== --}}
<section class="service-list">
  <div class="container service-grid">

    @foreach ($services as $category => $items)
    <div class="service-card category-card"
         onclick="openCategoryModal('{{ $category }}')">

@php
  $categoryLower = strtolower($category);

  if (str_contains($categoryLower, 'laundry')) {
    $icon = 'fa-shirt';
  } elseif (
    str_contains($categoryLower, 'mobil') ||
    str_contains($categoryLower, 'car')
  ) {
    $icon = 'fa-car';
  } elseif (str_contains($categoryLower, 'motor')) {
    $icon = 'fa-motorcycle';
  } elseif (
    str_contains($categoryLower, 'rumah') ||
    str_contains($categoryLower, 'bersih') ||
    str_contains($categoryLower, 'home')
  ) {
    $icon = 'fa-house-chimney';
  } else {
    $icon = 'fa-layer-group';
  }
@endphp

<div class="icon">
  <i class="fa-solid {{ $icon }}"></i>
</div>


      <h3>{{ strtoupper($category) }}</h3>
      <p>{{ $items->count() }} layanan tersedia</p>

      <span class="btn btn-orange btn-sm">
        Lihat Layanan
      </span>
    </div>
    @endforeach

  </div>
</section>

{{-- ===================== MODAL ===================== --}}
<div class="service-modal" id="categoryModal">
  <div class="modal-box modal-modern">

    <div class="modal-header">
      <div>
        <h2 id="modalCategoryTitle"></h2>
        <p class="modal-subtitle">Pilih layanan sesuai kebutuhan Anda</p>
      </div>

      <button class="modal-close" onclick="closeCategoryModal()">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div class="modal-body">
      <div id="modalServices"></div>
    </div>

  </div>
</div>

@endsection
<script>
const servicesData = @json($services);
const whatsappNumbers = {
  laundry: '6281213133421',
  homeService: '6285117803421',
};

function getIcon(category) {
  category = category.toLowerCase();
  if (category.includes('laundry')) return 'fa-shirt';
  if (category.includes('motor')) return 'fa-motorcycle';
  if (category.includes('mobil') || category.includes('car')) return 'fa-car';
  return 'fa-layer-group';
}

function getWhatsAppNumber(category) {
  category = category.toLowerCase();
  return category.includes('laundry')
    ? whatsappNumbers.laundry
    : whatsappNumbers.homeService;
}

function openCategoryModal(category) {
  const modal   = document.getElementById('categoryModal');
  const title   = document.getElementById('modalCategoryTitle');
  const content = document.getElementById('modalServices');

  title.innerHTML = `<i class="fa-solid ${getIcon(category)}"></i> ${category}`;
  content.innerHTML = '';

  const grouped = {};

  servicesData[category].forEach(item => {
    if (!grouped[item.name]) {
      grouped[item.name] = {
        description: item.description,
        note: item.note,
        variants: []
      };
    }

    grouped[item.name].variants.push({
      type: item.type || 'Standar',
      unit: item.unit,
      duration: item.duration,
      price: item.price
    });
  });

  Object.entries(grouped).forEach(([name, data], index) => {
    content.innerHTML += `
      <div class="accordion-item">

        <button class="accordion-header"
                onclick="toggleAccordion(${index})">
          <div class="left">
            <i class="fa-solid ${getIcon(category)}"></i>
            <span>${name}</span>
          </div>
          <i class="fa-solid fa-chevron-down arrow"></i>
        </button>

        <div class="accordion-body" id="accordion-${index}">

          ${data.description ? `<p class="desc">${data.description}</p>` : ''}

          <div class="variant-list">
            ${data.variants.map(v => `
              <div class="variant-card">
                <div class="variant-left">
                  <strong>${v.type}</strong>
                  <small>⏱ ${v.duration}</small>
                </div>

                <div class="variant-right">
                  <span class="variant-price">
                    Rp ${Number(v.price).toLocaleString('id-ID')}
                  </span>
                  <small>${v.unit}</small>

                  <a href="https://wa.me/${getWhatsAppNumber(category)}?text=${encodeURIComponent(
                    `Halo Admin,

Saya ingin melakukan pemesanan layanan melalui EasyCleaner.
Berikut detail layanan yang saya pilih:

Nama Layanan : ${name}
Tipe Layanan : ${v.type}

Mohon informasi mengenai ketersediaan jadwal, estimasi waktu pengerjaan.
Terima kasih.`

                  )}"
                     class="btn btn-orange btn-xs"
                     target="_blank">
                    Pesan
                  </a>
                </div>
              </div>
            `).join('')}
          </div>

          ${data.note ? `<p class="note">ℹ️ ${data.note}</p>` : ''}

        </div>
      </div>
    `;
  });

  modal.classList.add('active');
}

function closeCategoryModal() {
  document.getElementById('categoryModal').classList.remove('active');
}

function toggleAccordion(index) {
  const body   = document.getElementById(`accordion-${index}`);
  const header = body.previousElementSibling;

  const isOpen = body.classList.contains('active');

  // Tutup semua dulu
  document.querySelectorAll('.accordion-body').forEach(el => el.classList.remove('active'));
  document.querySelectorAll('.accordion-header').forEach(el => el.classList.remove('active'));

  // Kalau sebelumnya BELUM terbuka → buka
  if (!isOpen) {
    body.classList.add('active');
    header.classList.add('active');
  }
}

</script>

