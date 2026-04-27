<?php

namespace App\Http\Controllers;

use App\Models\Paket;

class LandingController extends Controller
{
    public function __invoke()
    {
        $pakets = Paket::active()->get();

        return view('welcome', compact('pakets'));
    }
}
