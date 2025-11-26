@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-info d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail transaksi</h5>
            <a href="{{ route('transaksi.index') }}" class="btn btn-light btn-sm">Kembali</a>
        </div>

        <div class="card-body">
            <p>

            </p>
            {{-- Informasi transaksi --}}
            <h6 class="fw-bold mb-3">Informasi transaksi</h6>
            <table class="table table-sm table-bordered mb-4">
                <tr>
                    <th>Kode transaksi</th>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Pelanggan</th>
                    <td>{{ $transaksi->supplier->nama_supplier ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>

            {{-- Detail Produk --}}
            <h6 class="fw-bold mb-3">Detail Produk</h6>
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->komponens as $kom)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kom->nama_komponen }}</td>
                        <td>Rp {{ number_format($kom->harga, 0, ',', '.') }}</td>
                        <td>{{ $kom->pivot->jumlah }}</td>
                        <td>Rp {{ number_format($kom->pivot->sub_total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
