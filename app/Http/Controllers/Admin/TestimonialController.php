<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'booking.paket'])->latest()->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function toggleApproval(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => !$testimonial->is_approved]);

        $status = $testimonial->is_approved ? 'disetujui' : 'ditolak';

        return back()->with('success', "Testimoni berhasil {$status}.");
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
