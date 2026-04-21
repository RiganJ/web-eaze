@extends('layouts.cms')

@section('title', 'Kelola Harga Layanan')
@section('page-title', 'Kelola Harga Layanan')

@section('content')
@php
  $oldEditId = old('service_id');
  $oldFormMode = old('form_mode');
  $oldEditData = $oldFormMode === 'edit' ? [
    'id' => old('service_id'),
    'category' => old('category'),
    'name' => old('name'),
    'type' => old('type'),
    'unit' => old('unit'),
    'price' => old('price'),
    'note' => old('note'),
  ] : null;
@endphp

<div class="order-wrapper">
  <div class="order-card">
    <div class="order-header">
      <div>
        <h4>Harga Layanan</h4>
        <small>CRUD harga seluruh layanan untuk semua kategori</small>
      </div>

      <button class="btn btn-primary" type="button" onclick="openAddModal()">
        <i class="fa-solid fa-plus"></i> Tambah Layanan
      </button>
    </div>

    @if($errors->any())
      <div style="margin-bottom: 16px; padding: 12px 16px; border-radius: 10px; background: #fff1f2; color: #b42318;">
        <strong>Periksa kembali input layanan.</strong>
        <ul style="margin: 8px 0 0 18px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if($services->count())
      <div class="table-wrapper">
        <table class="order-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Kategori</th>
              <th>Nama</th>
              <th>Tipe</th>
              <th>Unit</th>
              <th>Harga</th>
              <th>Catatan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($services as $service)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $service->category }}</td>
                <td>{{ $service->name }}</td>
                <td>{{ $service->type ?: '-' }}</td>
                <td>{{ $service->unit ?: '-' }}</td>
                <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                <td>{{ $service->note ?: '-' }}</td>
                <td class="text-center">
                  <div class="action-group">
                    <button
                      class="btn-icon edit"
                      type="button"
                      onclick="openEditModal(@js([
                        'id' => $service->id,
                        'category' => $service->category,
                        'name' => $service->name,
                        'type' => $service->type,
                        'unit' => $service->unit,
                        'price' => $service->price,
                        'note' => $service->note,
                      ]))">
                      <i class="fa-solid fa-pen"></i>
                    </button>

                    <form action="{{ route('admin.layanan.prices.destroy', $service) }}" method="POST" class="delete-service-form" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button class="btn-icon delete" type="submit">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="empty-state">
        <i class="fa-solid fa-layer-group"></i>
        <p>Belum ada data layanan</p>
      </div>
    @endif
  </div>
</div>

<div class="modal" id="addServiceModal" style="display:none;">
  <div class="modal-content">
    <span class="modal-close" onclick="closeAddModal()">&times;</span>
    <h4>Tambah Layanan</h4>
    <form action="{{ route('admin.layanan.prices.store') }}" method="POST">
      @csrf
      <input type="hidden" name="form_mode" value="create">
      <input type="text" name="category" list="serviceCategories" placeholder="Kategori" value="{{ $oldFormMode === 'create' ? old('category') : '' }}" required>
      <input type="text" name="name" placeholder="Nama layanan" value="{{ $oldFormMode === 'create' ? old('name') : '' }}" required>
      <input type="text" name="type" placeholder="Tipe / size" value="{{ $oldFormMode === 'create' ? old('type') : '' }}">
      <input type="text" name="unit" placeholder="Unit" value="{{ $oldFormMode === 'create' ? old('unit') : '' }}">
      <input type="number" name="price" placeholder="Harga" min="0" value="{{ $oldFormMode === 'create' ? old('price') : '' }}" required>
      <input type="text" name="note" placeholder="Catatan" value="{{ $oldFormMode === 'create' ? old('note') : '' }}">
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>

<div class="modal" id="editServiceModal" style="display:none;">
  <div class="modal-content">
    <span class="modal-close" onclick="closeEditModal()">&times;</span>
    <h4>Edit Layanan</h4>
    <form id="editServiceForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="form_mode" value="edit">
      <input type="hidden" name="service_id" value="{{ $oldEditId }}">
      <input type="text" name="category" list="serviceCategories" placeholder="Kategori" required>
      <input type="text" name="name" placeholder="Nama layanan" required>
      <input type="text" name="type" placeholder="Tipe / size">
      <input type="text" name="unit" placeholder="Unit">
      <input type="number" name="price" placeholder="Harga" min="0" required>
      <input type="text" name="note" placeholder="Catatan">
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>

<datalist id="serviceCategories">
  @foreach($categories as $category)
    <option value="{{ $category }}"></option>
  @endforeach
</datalist>
@endsection

@push('scripts')
<script>
const oldFormMode = @json($oldFormMode);
const oldEditId = @json($oldEditId);
const oldEditData = @json($oldEditData);

function openAddModal() {
  document.getElementById('addServiceModal').style.display = 'block';
}

function closeAddModal() {
  document.getElementById('addServiceModal').style.display = 'none';
}

function openEditModal(service) {
  const form = document.getElementById('editServiceForm');
  form.action = '{{ url('admin/layanan/harga') }}/' + service.id;
  form.querySelector('input[name="service_id"]').value = service.id ?? '';
  form.querySelector('input[name="category"]').value = service.category ?? '';
  form.querySelector('input[name="name"]').value = service.name ?? '';
  form.querySelector('input[name="type"]').value = service.type ?? '';
  form.querySelector('input[name="unit"]').value = service.unit ?? '';
  form.querySelector('input[name="price"]').value = service.price ?? '';
  form.querySelector('input[name="note"]').value = service.note ?? '';
  document.getElementById('editServiceModal').style.display = 'block';
}

function closeEditModal() {
  document.getElementById('editServiceModal').style.display = 'none';
}

window.onclick = function(event) {
  const addModal = document.getElementById('addServiceModal');
  const editModal = document.getElementById('editServiceModal');
  if (event.target === addModal) addModal.style.display = 'none';
  if (event.target === editModal) editModal.style.display = 'none';
}

document.querySelectorAll('.delete-service-form').forEach((form) => {
  form.addEventListener('submit', function(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Hapus layanan ini?',
      text: 'Data harga layanan akan dihapus.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
});

if (oldFormMode === 'create') {
  openAddModal();
}

if (oldFormMode === 'edit' && oldEditId && oldEditData) {
  openEditModal(oldEditData);
}
</script>
@endpush
