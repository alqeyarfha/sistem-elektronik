@extends('layouts.dashboard')

@section('content')

<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">
<h3>Edit transaksi: {{ $transaksi->kode_transaksi }}</h3>
</div>

            <div class="card-body">
                {{-- Form untuk Update transaksi --}}
                <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                    @csrf
                    {{-- Laravel menggunakan directive @method('PUT') untuk request update --}}
                    @method('PUT')

                    {{-- Input Kode transaksi (Biasanya tidak diubah, tapi disertakan) --}}
                    <div class="mb-3">
                        <label for="kode_transaksi" class="form-label">Kode transaksi</label>
                        <input type="text"
                            class="form-control @error('kode_transaksi') is-invalid @enderror"
                            id="kode_transaksi"
                            name="kode_transaksi"
                            value="{{ old('kode_transaksi', $transaksi->kode_transaksi) }}"
                            required>
                        @error('kode_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Tanggal --}}
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal transaksi</label>
                        {{-- Mengambil bagian tanggal saja dari timestamp --}}
                        <input type="date"
                            class="form-control @error('tanggal') is-invalid @enderror"
                            id="tanggal"
                            name="tanggal"
                            value="{{ old('tanggal', \Carbon\Carbon::parse($transaksi->tanggal)->format('Y-m-d')) }}"
                            required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Pelanggan / Supplier --}}
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Pelanggan / Supplier</label>
                        <select class="form-select @error('supplier_id') is-invalid @enderror"
                            id="supplier_id"
                            name="supplier_id"
                            required>
                            <option value="">Pilih Pelanggan</option>
                            {{-- Loop melalui daftar suppliers/transaksis yang tersedia --}}
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{-- Cek apakah supplier_id transaksi saat ini cocok, atau jika ada old input --}}
                                    {{ old('supplier_id', $transaksi->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }} (ID: {{ $supplier->id }})
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Total Harga --}}
                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="number"
                            class="form-control @error('total_harga') is-invalid @enderror"
                            id="total_harga"
                            name="total_harga"
                            value="{{ old('total_harga', $transaksi->total_harga) }}"
                            required
                            min="0"
                            step="any">
                        @error('total_harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</div>
@endsection
