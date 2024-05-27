<?php

namespace App\Http\Controllers\Dashboard\Report;

use App\Models\SaleItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ReportSaleController extends Controller
{
    public function saleReport()
    {
        $data = SaleItem::with(['sale', 'item'])->filterChainingByUser('sale')->orderBy('created_at', 'DESC')->get();
        return view('dashboard.pages.report.sale-report', compact('data'));
    }

    public function exportToPDF()
    {
        $currentDate = now()->format('dmY');
        $data = SaleItem::with(['sale', 'item'])->filterChainingByUser('sale')->orderBy('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('templates.pdf.contents.sale-report', compact('data'));

        return $pdf->download("{$currentDate}-stockflow-laporan-transaksi-penjualan.pdf");
    }
}
