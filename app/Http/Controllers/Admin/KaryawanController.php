<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')->latest()->get();

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'karyawan',
            'status' => 'active',
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(User $karyawan)
    {
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, User $karyawan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$karyawan->id}",
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $karyawan->update($validated);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $karyawan->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil diupdate.');
    }

    public function destroy(User $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
