<?php

namespace App\Http\Controllers\Dashboard\Report;

use Illuminate\Http\Request;
use App\Models\IncomingGoodsItem;
use App\Http\Controllers\Controller;

class ReportIncomingGoodsController extends Controller
{
    public function incomingReport()
    {
        $data = IncomingGoodsItem::with(['incomingGoods', 'item'])->filterChainingByUser('incomingGoods')->orderBy('created_at', 'DESC')->get();
        return view('dashboard.pages.report.incoming-report', compact('data'));
    }
}
