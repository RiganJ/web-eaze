@extends('layouts.cms')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')

@php
  $currentUser = auth()->user();
  $canResetPassword = auth()->check() && $currentUser->role === 'super_admin';
  $roleLabels = $roles ?? [];
  $oldEditUserId = old('edit_user_id');
  $oldEditUser = old('form_mode') === 'edit' ? [
    'id' => old('edit_user_id'),
    'name' => old('name'),
    'email' => old('email'),
    'role' => old('role'),
    'is_active' => old('is_active', '1'),
  ] : null;
@endphp

<div class="order-wrapper">
  <div class="order-card">

    <div class="order-header">
      <div>
        <h4>Kelola Pengguna</h4>
        <small>Manajemen akun, role, dan status pengguna sistem</small>
      </div>

      <button class="btn btn-primary" type="button" onclick="openAddModal()">
        <i class="fa-solid fa-user-plus"></i> Tambah User
      </button>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger" style="margin-bottom: 16px; padding: 12px 16px; border-radius: 10px; background: #fff1f2; color: #b42318;">
        <strong>Periksa kembali input user.</strong>
        <ul style="margin: 8px 0 0 18px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if($users->count())
    <div class="table-wrapper">
      <table class="order-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td class="text-center">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              <span class="badge role-{{ $user->role }}">{{ $roleLabels[$user->role] ?? strtoupper($user->role) }}</span>
            </td>
            <td>
              @if($user->is_active)
                <span class="status status-done">ACTIVE</span>
              @else
                <span class="status status-cancel">DISABLED</span>
              @endif
            </td>
            <td class="text-center">
              <div class="action-group">
                <button
                  class="btn-icon edit"
                  type="button"
                  onclick="openEditModal(@js([
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "role" => $user->role,
                    "is_active" => (int) $user->is_active,
                  ]))">
                  <i class="fa-solid fa-pen"></i>
                </button>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;" class="delete-user-form">
                  @csrf
                  @method('DELETE')
                  <button class="btn-icon delete" type="submit" {{ $currentUser && $currentUser->id === $user->id ? 'disabled' : '' }}>
                    <i class="fa-solid fa-ban"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="pagination-wrapper">
      {{ $users->links() }}
    </div>

    @else
      <div class="empty-state">
        <i class="fa-solid fa-users"></i>
        <p>Belum ada pengguna</p>
      </div>
    @endif

  </div>
</div>

<div class="modal" id="addUserModal" style="display: none;">
  <div class="modal-content">
    <span class="modal-close" onclick="closeAddModal()">&times;</span>
    <h4>Tambah User</h4>
    <form action="{{ route('admin.users.store') }}" method="POST" id="addUserForm">
      @csrf
      <input type="hidden" name="form_mode" value="create">
      <input type="text" name="name" placeholder="Nama" value="{{ old('form_mode') === 'create' ? old('name') : '' }}" required>
      <input type="email" name="email" placeholder="Email" value="{{ old('form_mode') === 'create' ? old('email') : '' }}" required>
      <select name="role" required>
        <option value="">Pilih role</option>
        @foreach($roleLabels as $value => $label)
          <option value="{{ $value }}" {{ old('form_mode') === 'create' && old('role') === $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>
      <select name="is_active" required>
        <option value="1" {{ old('form_mode') === 'create' ? (old('is_active', '1') == '1' ? 'selected' : '') : 'selected' }}>Aktif</option>
        <option value="0" {{ old('form_mode') === 'create' && old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
      </select>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
      <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
  </div>
</div>

<div class="modal" id="editUserModal" style="display: none;">
  <div class="modal-content">
    <span class="modal-close" onclick="closeEditModal()">&times;</span>
    <h4>Edit User</h4>
    <form id="editUserForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="form_mode" value="edit">
      <input type="hidden" name="edit_user_id" value="{{ $oldEditUserId }}">
      <input type="text" name="name" placeholder="Nama" required>
      <input type="email" name="email" placeholder="Email" required>
      <select name="role" required>
        <option value="">Pilih role</option>
        @foreach($roleLabels as $value => $label)
          <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
      </select>
      <select name="is_active" required>
        <option value="1">Aktif</option>
        <option value="0">Nonaktif</option>
      </select>
      @if($canResetPassword)
        <input type="password" name="password" placeholder="Password baru (opsional)">
        <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru">
        <small style="display:block; margin-top:8px; color:#666;">
          Kosongkan password jika tidak ingin mereset password user.
        </small>
      @endif
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
const canResetPassword = @json($canResetPassword);
const editActionTemplate = @json(url('/admin/users/__ID__'));
const oldFormMode = @json(old('form_mode'));
const oldEditUserId = @json($oldEditUserId);
const oldEditUser = @json($oldEditUser);

function openAddModal() {
    document.getElementById('addUserModal').style.display = 'block';
}

function closeAddModal() {
    document.getElementById('addUserModal').style.display = 'none';
}

function openEditModal(user) {
    const form = document.getElementById('editUserForm');
    form.action = editActionTemplate.replace('__ID__', user.id);
    form.querySelector('input[name="edit_user_id"]').value = user.id;
    form.querySelector('input[name="name"]').value = user.name ?? '';
    form.querySelector('input[name="email"]').value = user.email ?? '';
    form.querySelector('select[name="role"]').value = user.role ?? '';
    form.querySelector('select[name="is_active"]').value = String(user.is_active ?? '1');

    if (canResetPassword) {
        form.querySelector('input[name="password"]').value = '';
        form.querySelector('input[name="password_confirmation"]').value = '';
    }

    document.getElementById('editUserModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editUserModal').style.display = 'none';
}

window.onclick = function(event) {
    const addModal = document.getElementById('addUserModal');
    const editModal = document.getElementById('editUserModal');

    if (event.target === addModal) addModal.style.display = 'none';
    if (event.target === editModal) editModal.style.display = 'none';
};

document.querySelectorAll('.delete-user-form').forEach((form) => {
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus user ini?',
            text: 'Data user akan dihapus permanen.',
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

if (oldFormMode === 'edit' && oldEditUserId && oldEditUser) {
    openEditModal(oldEditUser);
}
</script>
@endpush
