<?php

namespace App\Http\Controllers\Homecleaning;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔒 Cek apakah user login dan role = HomeCleaning (3)
        if (!Auth::check() || Auth::user()->role != 3) {
            abort(403, 'AKSES DITOLAK');
        }

        // Kirim view dashboard HomeCleaning
        return view('admin.homecleaning.dashboard');
    }
}
