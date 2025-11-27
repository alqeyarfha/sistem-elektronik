@extends('layouts.dashboard')

@section('content')
<p>

</p>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('Komponen') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('komponen.create') }}" class="btn btn-outline-primary">Tambah Data</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Komponen</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Supplier</th> <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($komponen as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->nama_komponen }}</td>
                                    <td>{!! $data->harga !!}</td>
                                    <td>{{ $data->stok}}</td>

                                    {{-- Kolom Kategori --}}
                                    <td>{{ $data->kategori?->nama_kategori }}</td>
                                    <td>{{ $data->supplier?->nama_supplier }}</td>

                                    <td>
                                        <form action="{{ route('komponen.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('komponen.show', $data->id) }}"
                                                class="btn btn-sm btn-outline-info">Show</a> |
                                            <a href="{{ route('komponen.edit', $data->id) }}"
                                                class="btn btn-sm btn-outline-success">Edit</a> |
                                            <button type="submit"
                                                onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');"
                                                class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Data belum Tersedia.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $komponen->withQueryString()->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
