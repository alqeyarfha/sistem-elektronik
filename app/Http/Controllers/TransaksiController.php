<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Komponen;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['supplier', 'komponens'])->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $supplier = Supplier::all();
        $komponen    = Komponen::all();
        return view('transaksi.create', compact('supplier', 'komponen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'id_komponen'    => 'required|array',
            'id_komponen.*'  => 'exists:komponens,id',
            'jumlah'       => 'required|array',
            'jumlah.*'     => 'integer|min:1',
        ]);

        $kode                      = 'TRX-' . strtoupper(uniqid());
        $transaksi                 = new Transaksi();
        $transaksi->kode_transaksi = $kode;
        $transaksi->id_supplier   = $request->id_supplier;
        $transaksi->tanggal        = now();
        $transaksi->total_harga    = 0;
        $transaksi->save();

        $totalHarga  = 0;
        $komponenPivot = [];

        foreach ($request->id_komponen as $index => $komponenId) {
            $komponen   = Komponen::findOrFail($komponenId);
            $jumlah   = $request->jumlah[$index];
            $subTotal = $komponen->harga * $jumlah;

            $komponenPivot[$komponenId] = [
                'jumlah'    => $jumlah,
                'sub_total' => $subTotal,
            ];

            $komponen->stok -= $jumlah;
            $komponen->save();

            $totalHarga += $subTotal;
        }

        $transaksi->komponens()->attach($komponenPivot);

        $transaksi->update(['total_harga' => $totalHarga]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['supplier', 'komponens'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

public function edit(Transaksi $transaksi)
{
    $suppliers = Supplier::all();
    return view('transaksi.edit', compact('transaksi', 'suppliers'));
}

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'id_komponen'    => 'required|array',
            'id_komponen.*'  => 'exists:komponens,id',
            'jumlah'       => 'required|array',
            'jumlah.*'     => 'integer|min:1',
        ]);

        $transaksi = Transaksi::with('komponens')->findOrFail($id);

        foreach ($transaksi->komponens as $oldKomponen) {
            $p = Komponen::find($oldKomponen->id);
            if ($p) {
                $p->stok += $oldKomponen->pivot->jumlah;
                $p->save();
            }
        }

        $transaksi->komponens()->detach();

        $transaksi->id_supplier = $request->id_supplier;
        $transaksi->tanggal      = now();
        $transaksi->total_harga  = 0;
        $transaksi->save();

        $totalHarga  = 0;
        $komponenPivot = [];

        foreach ($request->id_komponen as $index => $komponenId) {
            $komponen   = Komponen::findOrFail($komponenId);
            $jumlah   = $request->jumlah[$index];
            $subTotal = $komponen->harga * $jumlah;

            $komponenPivot[$komponenId] = [
                'jumlah'    => $jumlah,
                'sub_total' => $subTotal,
            ];

            $komponen->stok -= $jumlah;
            $komponen->save();

            $totalHarga += $subTotal;
        }

        $transaksi->komponens()->attach($komponenPivot);

        $transaksi->update(['total_harga' => $totalHarga]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::with('komponens')->findOrFail($id);

        foreach ($transaksi->komponens as $komponen) {
            $p = Komponen::find($komponen->id);
            if ($p) {
                $p->stok += $komponen->pivot->jumlah;
                $p->save();
            }
        }

        $transaksi->komponens()->detach();

        // Hapus transaksi utama
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan!');
    }

    public function search(Request $request)
    {
        $query     = $request->query('query');
        $transaksi = Transaksi::with('supplier')
            ->where('kode_transaksi', 'like', "%$query%")
            ->get();

        return response()->json($transaksi);
    }

}
