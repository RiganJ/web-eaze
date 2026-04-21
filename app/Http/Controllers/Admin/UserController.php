<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const AVAILABLE_ROLES = [
        'super_admin' => 'Super Admin',
        'owner' => 'Owner',
        'admin_laundry' => 'Admin Laundry',
        'admin_homeclean' => 'Admin Homeclean',
        'admin_detailing' => 'Admin Detailing',
        'admin_carwash' => 'Admin Carwash',
        'admin_cucianmotor' => 'Admin Cucian Motor',
        'admin_karsobed' => 'Admin Karsobed',
        'admin_polish' => 'Admin Polish',
    ];

    public function index()
    {
        $users = User::latest()->paginate(10);
        $roles = self::AVAILABLE_ROLES;

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(array_keys(self::AVAILABLE_ROLES))],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'is_active' => ['required', 'boolean'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'is_active' => (bool) $validated['is_active'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(array_keys(self::AVAILABLE_ROLES))],
            'is_active' => ['required', 'boolean'],
        ];

        if ($request->filled('password')) {
            if (!Auth::check() || Auth::user()->role !== 'super_admin') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Hanya super admin yang dapat mereset password.');
            }

            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_active' => (bool) $validated['is_active'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', !empty($validated['password'])
                ? 'User dan password berhasil diperbarui'
                : 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return redirect()
                ->back()
                ->with('error', 'Akun yang sedang digunakan tidak bisa dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
