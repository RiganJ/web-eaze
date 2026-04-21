<?php

namespace App\Http\Controllers\Detailing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔒 Cek apakah user login dan role = Admin Detailing (4)
        if (!Auth::check() || Auth::user()->role != 4) {
            abort(403, 'AKSES DITOLAK');
        }

        // Kirim view dashboard Detailing
        return view('admin.detailing.dashboard');
    }
}
