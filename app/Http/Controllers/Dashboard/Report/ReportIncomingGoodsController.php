<?php

namespace App\Http\Controllers\Dashboard\Report;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\IncomingGoodsItem;
use App\Http\Controllers\Controller;

class ReportIncomingGoodsController extends Controller
{
    public function incomingReport()
    {
        $data = IncomingGoodsItem::with(['incomingGoods', 'item'])->filterChainingByUser('incomingGoods')->orderBy('created_at', 'DESC')->get();
        return view('dashboard.pages.report.incoming-report', compact('data'));
    }

    public function exportToPDF()
    {
        $currentDate = now()->format('dmY');
        $data = IncomingGoodsItem::with(['incomingGoods', 'item'])->filterChainingByUser('incomingGoods')->orderBy('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('templates.pdf.contents.incoming-report', compact('data'));

        return $pdf->download("{$currentDate}-stockflow-laporan-barang-masuk.pdf");
    }
}
