<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'karyawan'])->latest()->get();
        return view('owner.users.index', compact('users'));
    }

    public function create()
    {
        return view('owner.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['admin', 'karyawan'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('owner.users.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (!in_array($user->role, ['admin', 'karyawan'])) {
            abort(403, 'Hanya bisa mengedit akun admin dan karyawan.');
        }

        return view('owner.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!in_array($user->role, ['admin', 'karyawan'])) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'karyawan'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'status' => $validated['status'],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('owner.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!in_array($user->role, ['admin', 'karyawan'])) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('owner.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
