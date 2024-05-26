@extends('dashboard.layout.master')
@section('title', 'Laporan Transaksi Penjualan')

@section('content')

<!-- Tabel Laporan Transaksi Penjualan -->
<div class="card">
    <div class="d-flex align-items-center justify-content-between pe-4  ">
        <h5 class="card-header mb-0">Laporan Transaksi Penjualan</h5>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <caption class="ms-4">
                List Transaksi Penjualan
            </caption>
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
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
<!-- End Tabel Laporan Transaksi Penjualan -->
@endsection