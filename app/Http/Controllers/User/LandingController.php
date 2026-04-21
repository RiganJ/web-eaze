<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Testimonial; // Pastikan model ini sudah ada

class LandingController extends Controller
{
    public function index()
    {
        // Ambil testimoni yang statusnya 'approve' dari database
        $testimonials = Testimonial::where('status', 'approved')->get(); // Ambil testimoni yang statusnya 'approve'

        // Kirim data testimoni ke view
        return view('user.landing', ['testimonials' => $testimonials]); // Mengirim data ke view dengan nama 'testimonials'
    }
}
