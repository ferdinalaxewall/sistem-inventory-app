<?php

namespace App\Http\Controllers\Dashboard\Report;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    public function stockReport()
    {
        $data = Item::with('category')->orderBy('stock', 'ASC')->get();
        return view('dashboard.pages.report.stock-report', compact('data'));
    }
}
