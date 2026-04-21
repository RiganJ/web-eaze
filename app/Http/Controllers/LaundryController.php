<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class LaundryController extends Controller
{
public function index()
{
    // daftar keyword kategori yang dianggap LAUNDRY
    $laundryCategories = [
        'laundry',
        'karpet',
        'kasur',
        'spring bed',
        'sofa',
    ];

    $services = Service::all()
        ->groupBy('category')
        ->filter(function ($items, $category) use ($laundryCategories) {
            foreach ($laundryCategories as $keyword) {
                if (stripos($category, $keyword) !== false) {
                    return true;
                }
            }
            return false;
        });

    return view('layanan.laundry.index', compact('services'));
}

}


