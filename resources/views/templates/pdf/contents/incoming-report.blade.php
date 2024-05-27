@extends('templates.pdf.layouts.master')
@section('title', 'Lapooran Stok Barang')

@push('style')
    <style>
        #table-data, #table-data th, #table-data td {
            border: 1px solid #000;
        }

        #table-data {
            border-collapse: collapse;
        }

        #table-data th {
            height: 50px;
        }

        #table-data td {
            padding: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="bg-primary clr-white" style="padding: 0 20px; margin-bottom: 30px;">
        <table class="w-100 ">
            <tr>
                <td class="vertical-middle">
                    <h2 class="">{{ config('app.name') }}</h2>
                </td>
                <td class="vertical-middle text-right">
                    {{ now()->format('d-m-Y') }}
                </td>
            </tr>
        </table>
    </div>

    <h2 class="text-center">Laporan Barang Masuk <br> {{ auth()->user()->name }}</h2>

    <table class="w-100" id="table-data" style="margin-top: 30px;">
        <tr class="bg-primary clr-white">
            <th>No.</th>
            <th>Kode Barang Masuk</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Stok Awal</th>
            <th>Stok Akhir</th>
            <th>Tanggal</th>
        </tr>

        @foreach ($data as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->incomingGoods->code }}</td>
                <td>{{ $item->item->name }}</td>
                <td class="text-center">{{ "{$item->total_stock} {$item->item->unit}" }}</td>
                <td class="text-center">{{ "{$item->initial_stock} {$item->item->unit}" }}</td>
                <td class="text-center">{{ "{$item->current_stock} {$item->item->unit}" }}</td>
                <td class="text-center">{{ $item->incomingGoods->incoming_date?->translatedFormat('d F Y') }}</td>
            </tr>
        @endforeach
    </table>
@endsection