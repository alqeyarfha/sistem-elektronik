@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Detail Pembayaran') }} - **{{ $pembayaran->kode_pembayaran }}**
                    </div>
                    <div class="float-end">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th style="width: 150px;">Kode Pembayaran</th>
                                    <td>: **{{ $pembayaran->kode_pembayaran }}**</td>
                                </tr>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <td>: {{ $pembayaran->transaksi->kode_transaksi ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <td>: {{ \Carbon\Carbon::parse($pembayaran->transaksi->tanggal_transaksi ?? null)->isoFormat('D MMMM Y') ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Total Harga</th>
                                    <td>: **Rp. {{ number_format($pembayaran->transaksi->total_harga ?? 0, 0, ',', '.') }}**</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th style="width: 150px;">Tanggal Bayar</th>
                                    <td>: {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->isoFormat('D MMMM Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>: **{{ $pembayaran->metode_pembayaran }}**</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Bayar</th>
                                    <td>: **Rp. {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}**</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        : @php
                                            $kembalian = $pembayaran->jumlah_bayar - ($pembayaran->transaksi->total_harga ?? 0);
                                            $status_class = $kembalian < 0 ? 'text-danger' : ($kembalian > 0 ? 'text-success' : 'text-primary');
                                            $status_text = $kembalian < 0 ? 'Kurang Bayar: Rp. ' . number_format(abs($kembalian), 0, ',', '.') : ($kembalian > 0 ? 'Kembalian: Rp. ' . number_format($kembalian, 0, ',', '.') : 'Lunas');
                                        @endphp
                                        <strong class="{{ $status_class }}">{{ $status_text }}</strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <hr>
                        <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-success">Ubah Data</a>
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-secondary">Tutup</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
