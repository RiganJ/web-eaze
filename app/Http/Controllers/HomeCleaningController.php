<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;

class HomeCleaningController extends Controller
{
    public function index()
    {
        $homeCleaningCategories = [
            'vacum',
            'vacuum',
            'kaca',
            'lantai',
            'kristalisasi',
            'kamar mandi',
            'aquarium',
            'pembersihan', // menampung "Pembersihan Kamar Kos"
            'jasa kebersihan' // menampung "Jasa Kebersihan Rumah"
        ];

        $services = Service::all()
            ->groupBy('category')
            ->filter(function ($items, $category) use ($homeCleaningCategories) {
                foreach ($homeCleaningCategories as $keyword) {
                    if (stripos($category, $keyword) !== false) {
                        return true;
                    }
                }
                return false;
            });

        return view('layanan.homecleaning.index', compact('services'));
    }
}
