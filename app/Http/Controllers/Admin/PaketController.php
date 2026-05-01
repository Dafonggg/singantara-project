<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::latest()->get();

        return view('admin.paket.index', compact('pakets'));
    }

    public function create()
    {
        return view('admin.paket.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'jumlah_pemain' => 'required|integer|min:1',
            'durasi' => 'nullable|string|max:50',
            'daftar_isi' => 'nullable|array',
            'daftar_isi.*' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pakets', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        // Filter empty items from daftar_isi
        if (isset($validated['daftar_isi'])) {
            $validated['daftar_isi'] = array_values(array_filter($validated['daftar_isi'], fn($item) => !empty(trim($item))));
        }

        Paket::create($validated);

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Paket $paket)
    {
        return view('admin.paket.edit', compact('paket'));
    }

    public function update(Request $request, Paket $paket)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'jumlah_pemain' => 'required|integer|min:1',
            'durasi' => 'nullable|string|max:50',
            'daftar_isi' => 'nullable|array',
            'daftar_isi.*' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($paket->gambar) {
                Storage::disk('public')->delete($paket->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('pakets', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        // Filter empty items from daftar_isi
        if (isset($validated['daftar_isi'])) {
            $validated['daftar_isi'] = array_values(array_filter($validated['daftar_isi'], fn($item) => !empty(trim($item))));
        } else {
            $validated['daftar_isi'] = [];
        }

        $paket->update($validated);

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil diupdate.');
    }

    public function destroy(Paket $paket)
    {
        if ($paket->gambar) {
            Storage::disk('public')->delete($paket->gambar);
        }

        $paket->delete();

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil dihapus.');
    }
}
