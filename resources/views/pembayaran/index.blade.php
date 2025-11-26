@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Daftar Pembelian') }} 💳
                    </div>
                    <div class="float-end">
                        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">+ Tambah Pembayaran</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pembayaran</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Metode</th>
                                    <th>Status Pembayaran</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = ($pembayarans->currentPage() - 1) * $pembayarans->perPage() + 1;
                                @endphp
                                @forelse ($pembayarans as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->kode_pembayaran }}</td>
                                    <td>{{ $data->transaksi->kode_transaksi ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_bayar)->isoFormat('D MMMM Y') }}</td>
                                    <td>Rp. {{ number_format($data->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td>{{ $data->metode_pembayaran }}</td>

                                    <td>
                                        @php
                                            $total_harga = $data->transaksi->total_harga ?? 0;
                                            $kembalian = $data->jumlah_bayar - $total_harga;

                                            $status_class = '';
                                            $status_text = 'Menunggu Transaksi';

                                            if ($total_harga > 0) {
                                                if ($kembalian < 0) {
                                                    $status_class = 'text-danger fw-bold';
                                                    $status_text = 'Kurang Bayar: Rp. ' . number_format(abs($kembalian), 0, ',', '.');
                                                } elseif ($kembalian > 0) {
                                                    $status_class = 'text-success fw-bold';
                                                    $status_text = 'Kembalian: Rp. ' . number_format($kembalian, 0, ',', '.');
                                                } else {
                                                    $status_class = 'text-primary fw-bold';
                                                    $status_text = 'Lunas';
                                                }
                                            }
                                        @endphp
                                        <span class="{{ $status_class }}">{{ $status_text }}</span>
                                    </td>

                                    <td>
                                        <form action="{{ route('pembayaran.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('pembayaran.show', $data->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Lihat Detail">S</a>
                                            <a href="{{ route('pembayaran.edit', $data->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Ubah Data">E</a>
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data Pembayaran {{ $data->kode_pembayaran }} ini?');"
                                                class="btn btn-sm btn-outline-danger" title="Hapus Data">D </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Data Pembayaran belum Tersedia. 😥
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $pembayarans->withQueryString()->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
