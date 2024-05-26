@extends('dashboard.layout.master')
@section('title', 'Laporan Trannsaksi Penjualan')

@section('content')

<!-- Tabel Laporan Trannsaksi Penjualan -->
<div class="card">
    <div class="d-flex align-items-center justify-content-between pe-4  ">
        <h5 class="card-header mb-0">Laporan Trannsaksi Penjualan</h5>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <caption class="ms-4">
                List Trannsaksi Penjualan
            </caption>
            <thead>
                <tr>
                    <th>Kode Trannsaksi</th>
                    <th>Customer</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>HPP</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->sale->code }}</td>
                    <td>{{ $item->sale->customer?->name ?? '-' }}</td>
                    <td>{{ $item->item->name }}</td>
                    <td>{{ "{$item->quantity} {$item->item->unit}" }}</td>
                    <td>{{ $item->hpp }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->sale->created_at?->translatedFormat('d F Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- End Tabel Laporan Trannsaksi Penjualan -->
@endsection