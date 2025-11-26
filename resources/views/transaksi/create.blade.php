@extends('layouts.dashboard')

@section('content')
<p>

</p>
<div class="container">
    <h3 class="mb-4">Tambah pembelian Baru</h3>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf

                {{-- Pilih Pelanggan --}}
                <div class="mb-3">
                    <label for="id_supplier" class="form-label">Pelanggan</label>
                    <select name="id_supplier" id="id_supplier" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($supplier as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <h5>Daftar Produk</h5>

                {{-- Wrapper Produk --}}
                <div id="komponen-wrapper">
                    <div class="row komponen-item mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Produk</label>
                            <select name="id_komponen[]" class="form-select komponen-select" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($komponen as $prod)
                                <option value="{{ $prod->id }}" data-harga="{{ $prod->harga }}">
                                    {{ $prod->nama_komponen }} - Rp{{ number_format($prod->harga, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control subtotal" readonly value="Rp0">
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-remove w-100">×</button>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="button" class="btn btn-sm btn-secondary" id="btn-add">+ Tambah Produk</button>
                </div>

                <div class="text-end mb-4">
                    <h5>Total Harga: <span id="totalHarga">Rp0</span></h5>
                </div>

                <div class="text-end">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script JS --}}
<script>
    function hitungSubtotal() {
        let total = 0;
        document.querySelectorAll('.komponen-item').forEach(item => {
            let select = item.querySelector('.komponen-select');
            let jumlah = item.querySelector('.jumlah-input');
            let subtotalInput = item.querySelector('.subtotal');

            let harga = select.selectedOptions[0]?.getAttribute('data-harga') || 0;
            let sub = parseInt(harga) * parseInt(jumlah.value || 0);

            subtotalInput.value = 'Rp' + sub.toLocaleString('id-ID');
            total += sub;
        });

        document.getElementById('totalHarga').innerText = 'Rp' + total.toLocaleString('id-ID');
    }

    document.addEventListener('input', hitungSubtotal);
    document.addEventListener('change', hitungSubtotal);

    // Tambah komponen baru
    document.getElementById('btn-add').addEventListener('click', function() {
        let wrapper = document.getElementById('komponen-wrapper');
        let newRow = wrapper.firstElementChild.cloneNode(true);

        newRow.querySelectorAll('input').forEach(i => i.value = i.classList.contains('jumlah-input') ? 1 : 'Rp0');
        newRow.querySelector('.komponen-select').value = '';

        wrapper.appendChild(newRow);
    });

    // Hapus komponen
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove')) {
            let items = document.querySelectorAll('.komponen-item');
            if (items.length > 1) {
                e.target.closest('.komponen-item').remove();
                hitungSubtotal();
            }
        }
    });
</script>
@endsection
