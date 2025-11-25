@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Detail Pembayaran') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Kode Pembayaran:</strong> {{ $pembayaran->kode_pembayaran }}</li>
                        <li class="list-group-item"><strong>Kode Transaksi:</strong> {{ $pembayaran->transaksi->kode_transaksi ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Pelanggan Transaksi:</strong> {{ $pembayaran->transaksi->pelanggan->name ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Tanggal Bayar:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}</li>
                        <li class="list-group-item"><strong>Jumlah Bayar:</strong> Rp. {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</li>
                        <li class="list-group-item"><strong>Metode Pembayaran:</strong> {{ $pembayaran->metode_pembayaran }}</li>
                        <li class="list-group-item"><strong>Dibuat Pada:</strong> {{ $pembayaran->created_at }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
