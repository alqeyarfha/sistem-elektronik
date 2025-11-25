@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Daftar Pembayaran') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">+ Tambah Pembayaran</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pembayaran</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Metode</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($Pembayarans as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->kode_pembayaran }}</td>
                                    <td>{{ $data->transaksi->kode_transaksi ?? 'N/A' }}</td>
                                    <td>{{ $data->tanggal_bayar }}</td>
                                    <td>Rp. {{ number_format($data->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td>{{ $data->metode_pembayaran }}</td>
                                    <td>
                                        <form action="{{ route('pembayaran.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('pembayaran.show', $data->id) }}"
                                                class="btn btn-sm btn-outline-info">Show</a>
                                            <a href="{{ route('pembayaran.edit', $data->id) }}"
                                                class="btn btn-sm btn-outline-success">Edit</a>
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Data Pembayaran belum Tersedia.
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
