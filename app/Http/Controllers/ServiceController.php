<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function detailing()
    {
        /**
         * KATEGORI DETAILING & CLEANING
         * (berdasarkan NAMA CATEGORY)
         */
        $allowedCategories = [
            'mobil',
            'motor',

        ];

        $services = Service::where(function ($query) use ($allowedCategories) {
                foreach ($allowedCategories as $cat) {
                    $query->orWhere('category', 'LIKE', "%$cat%");
                }
            })
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        return view('layanan.detailing.index', compact('services'));
    }
}
