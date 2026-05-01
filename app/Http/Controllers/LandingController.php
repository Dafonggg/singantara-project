<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Paket;
use App\Models\Testimonial;

class LandingController extends Controller
{
    public function __invoke()
    {
        $pakets = Paket::active()->get();
        $galeris = Galeri::latest()->get();
        $testimonials = Testimonial::approved()
            ->with(['user', 'booking'])
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('pakets', 'galeris', 'testimonials'));
    }
}
