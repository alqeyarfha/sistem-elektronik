<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{

// app/Http/Controllers/PembayaranController.php

public function index()
{
    $pembayarans = Pembayaran::with('transaksi')->latest()->paginate(10);
    return view('pembayaran.index', compact('pembayarans'));
}
    public function create()
    {
        // Hanya ambil transaksi yang statusnya belum lunas (sesuaikan kondisi Anda)
        $transaksis = Transaksi::all();
        return view('pembayaran.create', compact('transaksis'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pembayaran' => 'required|string|max:255|unique:pembayarans',
            'transaksi_id' => 'required|exists:transaksis,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string|max:50',
        ]);

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')
                         ->with('success', 'Data Pembayaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail Pembayaran tertentu.
     */
    public function show(Pembayaran $pembayaran)
    {
        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Menampilkan form untuk mengedit Pembayaran tertentu.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $transaksis = Transaksi::all();
        return view('pembayaran.edit', compact('pembayaran', 'transaksis'));
    }

    /**
     * Memperbarui data Pembayaran tertentu di database.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            // Pastikan kode_pembayaran unik kecuali untuk data ini sendiri
            'kode_pembayaran' => 'required|string|max:255|unique:pembayarans,kode_pembayaran,' . $pembayaran->id,
            'transaksi_id' => 'required|exists:transaksis,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string|max:50',
        ]);

        $pembayaran->update($validated);

        return redirect()->route('pembayaran.index')
                         ->with('success', 'Data Pembayaran berhasil diperbarui.');
    }

    /**
     * Menghapus Pembayaran tertentu dari database.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
                         ->with('success', 'Data Pembayaran berhasil dihapus.');
    }
}
