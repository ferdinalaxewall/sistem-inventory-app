<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use App\Models\Customer;
use App\Models\SaleItem;
use App\Models\Supplier;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Helpers\Utilities\DateHelper;
use App\Helpers\Utilities\RandomGenerator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        // Generate Date Range for Filter Needed
        $dateRange = DateHelper::generateDateRange(
            $request->query('month'),
            $request->query('year')
        );

        // Global Count Items
        $data['count_items'] = Item::when(auth()->user()->role == User::USER_ROLE, function ($query) {
            $query->where('user_id', auth()->user()->uuid);
        })->count();
        $data['count_suppliers'] = Supplier::when(auth()->user()->role == User::USER_ROLE, function ($query) {
            $query->where('user_id', auth()->user()->uuid);
        })->count();
        $data['count_customers'] = Customer::when(auth()->user()->role == User::USER_ROLE, function ($query) {
            $query->where('user_id', auth()->user()->uuid);
        })->count();

        if (auth()->user()->role == User::ADMIN_ROLE) {
            // Stock Item Users Statistic
            $data['graph_categories'] = Item::with('user')
                ->select(['user_id', DB::raw('SUM(stock) as total_stock')])
                ->groupBy('user_id')
                ->get();
            $data['graph_categories'] = $data['graph_categories']->map(function ($item) use ($data) {
                $totalStock = $data['graph_categories']->sum('total_stock');
                $item['user_name'] = $item->user->name;
                $item['percentage'] = round(((int) $item['total_stock'] / $totalStock) * 100, 1);
                $item['color'] = RandomGenerator::generateRandomColor();

                return $item;
            });

            $data['best_items'] = SaleItem::with('item')
                ->select(['item_id', DB::raw('SUM(quantity) as total_quantity')])
                ->groupBy('item_id')
                ->orderBy('total_quantity', 'DESC')
                ->limit(5)->get();

            // Count Items
            $data['count_users'] = User::where('role', User::USER_ROLE)->count();

            // Sale Transaction Statistic
            $users = User::select(['uuid', 'name'])->get();
            $data['sale_graphs']['series_data'] = $users->map(fn ($item) => $item->sales()->whereDateRange('created_at', $dateRange->start_date, $dateRange->end_date)->count());
            $data['sale_graphs']['series_categories'] = $users->pluck('name');
        } else {
            // Stock Item Categories Statistic
            $data['graph_categories'] = Item::with('category')
                ->select(['item_category_id', DB::raw('SUM(stock) as total_stock')])
                ->where('user_id', auth()->user()->uuid)
                ->groupBy('item_category_id')
                ->get();
            $data['graph_categories'] = $data['graph_categories']->map(function ($item) use ($data) {
                $totalStock = $data['graph_categories']->sum('total_stock');
                $item['category_name'] = $item->category->category_name;
                $item['percentage'] = round(((int) $item['total_stock'] / $totalStock) * 100, 1);
                $item['color'] = RandomGenerator::generateRandomColor();

                return $item;
            });

            // Count Items
            $data['profits'] = SaleItem::select(DB::raw('SUM((price - hpp) * quantity) as profits'))
                ->whereHas('sale', fn ($query) => $query->where('user_id', auth()->user()->uuid))
                ->get()->sum('profits');

            // List Warning Items
            $data['warning_items'] = Item::where('stock', '<', Item::MIN_STOCK_ALERT)
                ->where('user_id', auth()->user()->uuid)
                ->get();
            
            // Sale Transaction Statistic
            $transactions = Sale::select('created_at as date')
                ->where('user_id', auth()->user()->uuid)
                ->whereDateRange('created_at', $dateRange->start_date, $dateRange->end_date)
                ->get();
            $data['sale_graphs']['series_data'] = collect([]);
            $data['sale_graphs']['series_categories'] = $periods = collect(CarbonPeriod::create($dateRange->start_date, $dateRange->end_date)->toArray())->map(function ($date) use ($transactions, $data) {
                $transaction = $transactions->filter(fn ($item) => Carbon::parse($item->date)->format('Y-m-d') == $date->format('Y-m-d'))->count();
                $data['sale_graphs']['series_data']->push($transaction);
    
                return $date->format('d');
            });
        }

        return view('dashboard.pages.dashboard.index', compact('data', 'dateRange'));
    }
}
