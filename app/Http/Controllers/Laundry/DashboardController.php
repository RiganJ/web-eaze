<?php

namespace App\Http\Controllers\Laundry;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role != 2) {
            abort(403, 'AKSES DITOLAK');
        }

        return view('dashboard.laundry.index');
    }
}
