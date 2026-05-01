<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $banks = BankAccount::latest()->get();
        return view('owner.bank-accounts.index', compact('banks'));
    }

    public function create()
    {
        return view('owner.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:255',
            'kode_bank' => 'required|string|max:50|unique:bank_accounts',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        BankAccount::create($validated);

        return redirect()->route('owner.bank-accounts.index')->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('owner.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:255',
            'kode_bank' => "required|string|max:50|unique:bank_accounts,kode_bank,{$bankAccount->id}",
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $bankAccount->update($validated);

        return redirect()->route('owner.bank-accounts.index')->with('success', 'Rekening bank berhasil diperbarui.');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect()->route('owner.bank-accounts.index')->with('success', 'Rekening bank berhasil dihapus.');
    }
}
