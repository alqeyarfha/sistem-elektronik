@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        {{ __('supplier') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-outline-primary">Tambah Data</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Nama supplier</th>
                                <td>{{$supplier->nama_supplier}}</td>
                            </tr>
                            <tr>
                                <th>Dosen Pengampu</th>
                                <td>{{$supplier->alamat}}</td>
                            </tr>
                            <tr>
                                <th>Nama Wali</th>
                                <td>{{$supplier->no_hp ?? '-'}}</td>
                            </tr>
                            <tr>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection