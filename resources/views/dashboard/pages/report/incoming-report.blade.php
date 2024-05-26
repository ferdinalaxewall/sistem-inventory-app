@extends('dashboard.layout.master')
@section('title', 'Laporan Barang Masuk')

@section('content')

<!-- Tabel Laporan Barang Masuk -->
<div class="card">
    <div class="d-flex align-items-center justify-content-between pe-4  ">
        <h5 class="card-header mb-0">Laporan Barang Masuk</h5>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <caption class="ms-4">
                List Barang Masuk
            </caption>
            <thead>
                <tr>
                    <th>Kode Barang Masuk</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Stok Awal</th>
                    <th>Stok Akhir</th>
                    <th>Tanggal</th>
                    <th>Dibuat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->incomingGoods->code }}</td>
                    <td>{{ $item->item->name }}</td>
                    <td>{{ "{$item->total_stock} {$item->item->unit}" }}</td>
                    <td>{{ "{$item->initial_stock} {$item->item->unit}" }}</td>
                    <td>{{ "{$item->current_stock} {$item->item->unit}" }}</td>
                    <td>{{ $item->incomingGoods->incoming_date?->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->incomingGoods->user?->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- End Tabel Laporan Barang Masuk -->
@endsection