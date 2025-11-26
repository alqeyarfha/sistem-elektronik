@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"> {{-- Mengubah col-md-8 menjadi col-md-12 agar lebih lebar, mengikuti index --}}
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Tambah Data Pembayaran') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> {{-- Menambahkan ikon untuk tombol Kembali (jika menggunakan Font Awesome) --}}
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Pesan Sukses/Error (Opsional: jika Anda menggunakan session flash) --}}
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('pembayaran.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="kode_pembayaran" class="form-label">Kode Pembayaran</label>
                            <input type="text" class="form-control @error('kode_pembayaran') is-invalid @enderror"
                                id="kode_pembayaran" name="kode_pembayaran"
                                value="{{ old('kode_pembayaran', 'PB-' . time()) }}"
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
                                            {{ old('transaksi_id') == $transaksi->id ? 'selected' : '' }}>
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
                                value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                            @error('tanggal_bayar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_bayar" class="form-label">Jumlah Bayar (Rp)</label>
                            {{-- Mengubah type="number" menjadi type="text" dan menambahkan inputmask atau format rupiah jika menggunakan JS library,
                                tapi untuk kemudahan validasi, kita tetap pakai type="number" dan step="1" atau hilangkan step --}}
                            <input type="number" step="1" class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                id="jumlah_bayar" name="jumlah_bayar"
                                value="{{ old('jumlah_bayar') }}" required placeholder="Contoh: 4700000">
                            @error('jumlah_bayar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Tambahan untuk Kembalian --}}
                        <div class="mb-3">
                            <label class="form-label">Kembalian</label>
                            <input type="text" class="form-control" id="kembalian" value="Rp. 0" readonly>
                        </div>
                        {{-- Akhir Tambahan Kembalian --}}

                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select @error('metode_pembayaran') is-invalid @enderror"
                                id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="Cash" {{ old('metode_pembayaran') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Transfer Bank" {{ old('metode_pembayaran') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="Kartu Kredit" {{ old('metode_pembayaran') == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                <option value="E-Wallet" {{ old('metode_pembayaran') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option> {{-- Menambahkan opsi umum --}}
                            </select>
                            @error('metode_pembayaran')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <hr>
                            <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary float-end">Simpan Pembayaran</button>
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
         * Hanya untuk tampilan di frontend.
         */
        function formatRupiah(angka, prefix) {
            // Hilangkan semua karakter selain digit dan koma (jika menggunakan koma sebagai desimal)
            var number_string = angka.toString().replace(/[^,\d]/g, '');

            // Jika input adalah float/decimal, gunakan titik sebagai pemisah ribuan dan koma sebagai desimal
            var parts = number_string.split('.'); // Asumsi input dari <input type="number"> menggunakan titik sebagai desimal secara default pada JS
            var split = parts[0].toString().split(','), // Split bagian integer
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            // Tambahkan bagian desimal (jika ada)
            // Di Indonesia, biasanya menggunakan koma untuk desimal, tetapi karena input type=number, kita biarkan saja
            // Mengingat kasus pembayaran umumnya menggunakan bilangan bulat, kita fokus pada pemisah ribuan
            rupiah = parts.length > 1 ? rupiah + ',' + parts[1].substring(0, 2) : rupiah;

            return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        /**
         * Fungsi untuk menghitung dan menampilkan kembalian.
         */
        function hitungKembalian() {
            var selectedOption = $('#transaksi_id').find('option:selected');
            var totalHarga = parseFloat(selectedOption.data('total-harga')) || 0;
            // Gunakan parseFloat untuk mendapatkan nilai angka dari input jumlah_bayar
            var jumlahBayar = parseFloat($('#jumlah_bayar').val()) || 0;

            // --- Bagian Tampilkan Total Harga ---
            $('#info_total_harga').text('Total Harga Transaksi: ' + formatRupiah(totalHarga, 'Rp. '));
            $('#info_total_harga').toggleClass('text-primary', totalHarga > 0);
            // ------------------------------------

            var kembalian = jumlahBayar - totalHarga;

            // --- Bagian Tampilkan Kembalian ---
            $('#kembalian').val(formatRupiah(Math.abs(kembalian), 'Rp. ')); // Tampilkan nilai absolut

            // Berikan highlight
            $('#kembalian').removeClass('text-danger text-success text-muted');
            if (kembalian < 0) {
                $('#kembalian').addClass('text-danger').val('Kurang Bayar: ' + formatRupiah(Math.abs(kembalian), 'Rp. '));
            } else if (kembalian > 0) {
                $('#kembalian').addClass('text-success').val('Kembalian: ' + formatRupiah(kembalian, 'Rp. '));
            } else {
                 $('#kembalian').addClass('text-muted').val('Pas / Belum Bayar');
            }
            // ------------------------------------
        }

        // Event listener saat transaksi dipilih
        $('#transaksi_id').on('change', function() {
            hitungKembalian();
        });

        // Event listener saat jumlah bayar diinput
        $('#jumlah_bayar').on('input', function() {
            hitungKembalian();
        });

        // Panggil saat halaman pertama kali dimuat (untuk old value jika ada)
        hitungKembalian();
    });
</script>
@endpush
