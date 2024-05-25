@extends('dashboard.layout.master')
@section('title', 'Laporan Stok Barang')

@section('content')

<!-- Tabel Laporan Stok Barang -->
<div class="card">
    <div class="d-flex align-items-center justify-content-between pe-4  ">
        <h5 class="card-header mb-0">Laporan Stok Barang</h5>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <caption class="ms-4">
                List Stok Barang
            </caption>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Stok</th>
                    <th>Harga Beli (HPP)</th>
                    <th>Harga Jual</th>
                    <th>Dibuat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ "{$item->stock} {$item->unit}" }}</td>
                    <td>{{ $item->hpp }}</td>
                    <td>{{ $item->selling_price }}</td>
                    <td>{{ $item->user?->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- End Tabel Laporan Stok Barang -->
@endsection