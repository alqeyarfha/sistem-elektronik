@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Data Pembayaran') }}</div>

                <div class="card-body">
                    <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="kode_pembayaran" class="form-label">Kode Pembayaran</label>
                            <input type="text" class="form-control @error('kode_pembayaran') is-invalid @enderror"
                                id="kode_pembayaran" name="kode_pembayaran"
                                value="{{ old('kode_pembayaran', $pembayaran->kode_pembayaran) }}"
                                required placeholder="Contoh: PB-20251125">
                            @error('kode_pembayaran')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="transaksi_id" class="form-label">Pilih Transaksi</label>
                            <select class="form-select @error('transaksi_id') is-invalid @enderror"
                                id="transaksi_id" name="transaksi_id" required>
                                @foreach ($transaksis as $transaksi)
                                    <option value="{{ $transaksi->id }}"
                                            {{ old('transaksi_id', $pembayaran->transaksi_id) == $transaksi->id ? 'selected' : '' }}>
                                        {{ $transaksi->kode_transaksi }} (Total: Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('transaksi_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                            <input type="date" class="form-control @error('tanggal_bayar') is-invalid @enderror"
                                id="tanggal_bayar" name="tanggal_bayar"
                                value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar) }}" required>
                            @error('tanggal_bayar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_bayar" class="form-label">Jumlah Bayar (Rp)</label>
                            <input type="number" step="0.01" class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                id="jumlah_bayar" name="jumlah_bayar"
                                value="{{ old('jumlah_bayar', $pembayaran->jumlah_bayar) }}"
                                required placeholder="Contoh: 4700000">
                            @error('jumlah_bayar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select @error('metode_pembayaran') is-invalid @enderror"
                                id="metode_pembayaran" name="metode_pembayaran" required>
                                @php
                                    $selectedMetode = old('metode_pembayaran', $pembayaran->metode_pembayaran);
                                @endphp
                                <option value="Cash" {{ $selectedMetode == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Transfer Bank" {{ $selectedMetode == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="Kartu Kredit" {{ $selectedMetode == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                            </select>
                            @error('metode_pembayaran')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-success float-end">Update Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
