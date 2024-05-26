<?php

namespace App\Http\Controllers\Dashboard\Transaction;

use Illuminate\Http\Request;
use App\Models\IncomingGoods;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\IncomingGoodsRequest;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class IncomingGoodsController extends Controller
{
    public function index()
    {
        $data = IncomingGoods::filterByUser()->latest()->get();
        return view('dashboard.pages.transaction.incoming.index', compact('data'));
    }

    public function create()
    {
        $suppliers = Supplier::filterByUser()->orderBy('name', 'ASC')->get();
        $items = Item::filterByUser()->orderBy('name', 'ASC')->get();

        return view('dashboard.pages.transaction.incoming.create', compact('suppliers', 'items'));
    }   

    public function store(IncomingGoodsRequest $request)
    {
        $requestDTO = $request->validated();

        DB::beginTransaction();
        try {
            $requestDTO['code'] = (new IncomingGoods)->generateUniqueCode(IncomingGoods::UNIQUE_CODE_PREFIX);
            $requestDTO['user_id'] = auth()->user()->uuid;
            $items = $requestDTO['items'];
            unset($requestDTO['items']);

            $createdIncomingGoods = IncomingGoods::create($requestDTO);

            foreach ($items as $item) {
                $itemData = Item::where('uuid', $item['item_id'])->first();
                $createdIncomingGoods->items()->create([
                    'item_id' => $item['item_id'],
                    'initial_stock' => $itemData->stock,
                    'total_stock' => $item['total_stock'],
                    'current_stock' => $itemData->stock + $item['total_stock']
                ]);

                $itemData->update([
                    'stock' => $itemData->stock + $item['total_stock']
                ]);
            }

            DB::commit();
            return redirect()->route('dashboard.transaction.incoming.index')->with('toastSuccess', __('crud.created', ['name' => 'Barang Masuk']));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.transaction.incoming.create')->with('toastError', __('crud.error_create', ['name' => 'Barang Masuk']))->withInput();
        }
    }

    public function delete(string $uuid)
    {

        DB::beginTransaction();
        try {
            $incomingGoods = IncomingGoods::where('uuid', $uuid)->first();
            if (is_null($incomingGoods)) {
                return redirect()->route('dashboard.transaction.incoming.index', $uuid)->with('toastError', __('crud.not_found', ['name' => 'Barang Masuk']));
            }

            foreach ($incomingGoods->items as $item) {
                $incomingGoodsItem = $item->item;
                $incomingGoodsItem->update([
                    'stock' => $incomingGoodsItem->stock - $item->total_stock
                ]);
            }
            
            $incomingGoods->delete();

            DB::commit();
            return redirect()->route('dashboard.transaction.incoming.index')->with('toastSuccess', __('crud.deleted', ['name' => 'Barang Masuk']));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.transaction.incoming.index', $uuid)->with('toastError', __('crud.error_delete', ['name' => 'Barang Masuk']))->withInput();
        }
    }
}
