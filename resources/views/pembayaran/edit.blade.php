@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Ubah Data Pembayaran') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Menggunakan method PUT untuk UPDATE --}}

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
                            <label for="transaksi_id" class="form-label">Pilih Pembelian / Transaksi</label>
                            <select class="form-select @error('transaksi_id') is-invalid @enderror"
                                id="transaksi_id" name="transaksi_id" required>
                                <option value="" data-total-harga="0">-- Pilih Transaksi --</option>
                                @foreach ($transaksis as $transaksi)
                                    <option value="{{ $transaksi->id }}"
                                            data-total-harga="{{ $transaksi->total_harga }}"
                                            {{ old('transaksi_id', $pembayaran->transaksi_id) == $transaksi->id ? 'selected' : '' }}>
                                        {{ $transaksi->kode_transaksi }} (Total: **Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}**)
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-2" id="info_total_harga" style="font-weight: bold;"></div>
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
                            <input type="number" step="1" class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                id="jumlah_bayar" name="jumlah_bayar"
                                value="{{ old('jumlah_bayar', $pembayaran->jumlah_bayar) }}" required placeholder="Contoh: 4700000">
                            @error('jumlah_bayar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Tambahan untuk Kembalian --}}
                        <div class="mb-3">
                            <label class="form-label">Status Pembayaran</label>
                            <input type="text" class="form-control" id="kembalian" value="Rp. 0" readonly>
                        </div>
                        {{-- Akhir Tambahan Kembalian --}}

                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select @error('metode_pembayaran') is-invalid @enderror"
                                id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">-- Pilih Metode --</option>
                                @foreach (['Cash', 'Transfer Bank', 'Kartu Kredit', 'E-Wallet'] as $metode)
                                    <option value="{{ $metode }}" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == $metode ? 'selected' : '' }}>
                                        {{ $metode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('metode_pembayaran')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <hr>
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

@push('scripts')
<script>
    // Pastikan jQuery sudah dimuat di layouts/dashboard
    $(document).ready(function() {
        /**
         * Fungsi untuk memformat angka menjadi format Rupiah.
         */
        function formatRupiah(angka, prefix) {
            var number_string = angka.toString().replace(/[^,\d]/g, '');
            var parts = number_string.split('.');
            var split = parts[0].toString().split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = parts.length > 1 ? rupiah + ',' + parts[1].substring(0, 2) : rupiah;

            return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        /**
         * Fungsi untuk menghitung dan menampilkan status pembayaran (kembalian/kurang bayar).
         */
        function hitungKembalian() {
            var selectedOption = $('#transaksi_id').find('option:selected');
            var totalHarga = parseFloat(selectedOption.data('total-harga')) || 0;
            var jumlahBayar = parseFloat($('#jumlah_bayar').val()) || 0;

            // --- Bagian Tampilkan Total Harga ---
            $('#info_total_harga').text('Total Harga Transaksi: ' + formatRupiah(totalHarga, 'Rp. '));
            $('#info_total_harga').toggleClass('text-primary', totalHarga > 0);
            // ------------------------------------

            var kembalian = jumlahBayar - totalHarga;

            // --- Bagian Tampilkan Kembalian ---
            $('#kembalian').removeClass('text-danger text-success text-muted');
            if (kembalian < 0) {
                $('#kembalian').addClass('text-danger').val('Kurang Bayar: ' + formatRupiah(Math.abs(kembalian), 'Rp. '));
            } else if (kembalian > 0) {
                $('#kembalian').addClass('text-success').val('Kembalian: ' + formatRupiah(kembalian, 'Rp. '));
            } else {
                 $('#kembalian').addClass('text-muted').val('Pas / Lunas');
            }
            // ------------------------------------
        }


        $('#transaksi_id').on('change', function() {
            hitungKembalian();
        });


        $('#jumlah_bayar').on('input', function() {
            hitungKembalian();
        });

        hitungKembalian();
    });
</script>
@endpush
