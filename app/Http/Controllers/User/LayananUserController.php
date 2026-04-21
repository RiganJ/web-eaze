<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;

class LayananUserController extends Controller
{
    public function index()
    {
        $services = Service::all()
            ->groupBy(function ($item) {
                $cat = strtolower($item->category);

                if (str_contains($cat, 'laundry')) {
                    return 'Laundry';
                }

                if (str_contains($cat, 'clean')) {
                    return 'Home Cleaning';
                }

                if (str_contains($cat, 'car')) {
                    return 'Car Wash';
                }

                if (str_contains($cat, 'motor')) {
                    return 'Motorcycle Wash';
                }

                return 'Lainnya';
            });

        return view('user.services.index', compact('services'));
    }

    public function show($service)
    {
        return "Halaman detail layanan: " . ucfirst(str_replace('-', ' ', $service));
    }
}
