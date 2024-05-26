<?php

namespace App\Http\Controllers\Dashboard\Transaction;

use App\Models\Item;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Exceptions\ReturnPaymentException;
use App\Exceptions\IncorrectStockException;
use App\Http\Requests\Transaction\SaleRequest;

class SaleController extends Controller
{
    public function index()
    {
        $data = Sale::filterByUser()->latest()->get();
        return view('dashboard.pages.transaction.sale.index', compact('data'));
    }

    public function create()
    {
        $customers = Customer::filterByUser()->orderBy('name', 'ASC')->get();
        $items = Item::filterByUser()->orderBy('name', 'ASC')->get();

        return view('dashboard.pages.transaction.sale.create', compact('customers', 'items'));
    }   

    public function store(SaleRequest $request)
    {
        $requestDTO = $request->validated();

        DB::beginTransaction();
        try {
            $requestDTO['code'] = (new Sale)->generateUniqueCode(Sale::UNIQUE_CODE_PREFIX);
            $requestDTO['user_id'] = auth()->user()->uuid;
            $items = collect($requestDTO['items'])->map(function ($item) {
                $item['quantity'] = (int) $item['quantity'];
                $item['price'] = (int) $item['price'];
                $item['subtotal'] = $item['quantity'] * $item['price'];

                return $item;
            });

            unset($requestDTO['items']);
            $requestDTO['subtotal'] = $items->sum('subtotal');
            $requestDTO['total_payment'] = (int) $requestDTO['total_payment'];
            $requestDTO['return_payment'] = $requestDTO['total_payment'] - $requestDTO['subtotal'];

            if ($requestDTO['return_payment'] < 0) throw new ReturnPaymentException('Nominal Pembayaran Harus Lebih Besar atau Sama dengan Subtotal');

            $createdSale = Sale::create($requestDTO);

            foreach ($items as $item) {
                $itemData = Item::where('uuid', $item['item_id'])->first();
                $createdSale->items()->create([
                    'item_id' => $item['item_id'],
                    'hpp' => $itemData->hpp,
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ]);

                if ($itemData->stock < $item['quantity']) throw new IncorrectStockException("Jumlah Stok Barang Tidak Mencukupi, Total Stok {$itemData->name}: {$itemData->stock}");

                $itemData->update([
                    'stock' => $itemData->stock - $item['quantity']
                ]);
            }

            DB::commit();
            return redirect()->route('dashboard.transaction.sale.index')->with('toastSuccess', __('crud.created', ['name' => 'Transaksi Penjualan']));
        } catch (ReturnPaymentException $ex) {
            DB::rollBack();
            return redirect()->route('dashboard.transaction.sale.create')->with('toastError', $ex->getMessage())->withInput();
        } catch (IncorrectStockException $ex) {
            DB::rollBack();
            return redirect()->route('dashboard.transaction.sale.create')->with('toastError', $ex->getMessage())->withInput();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.transaction.sale.create')->with('toastError', __('crud.error_create', ['name' => 'Transaksi Penjualan']))->withInput();
        }
    }

    public function delete(string $uuid)
    {
        DB::beginTransaction();
        try {
            $sale = Sale::where('uuid', $uuid)->first();
            if (is_null($sale)) {
                return redirect()->route('dashboard.transaction.sale.index', $uuid)->with('toastError', __('crud.not_found', ['name' => 'Transaksi Penjualan']));
            }

            foreach ($sale->items as $item) {
                $saleItem = $item->item;
                $saleItem->update([
                    'stock' => $saleItem->stock + $item->quantity
                ]);
            }
            
            $sale->delete();

            DB::commit();
            return redirect()->route('dashboard.transaction.sale.index')->with('toastSuccess', __('crud.deleted', ['name' => 'Transaksi Penjualan']));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->route('dashboard.transaction.sale.index', $uuid)->with('toastError', __('crud.error_delete', ['name' => 'Transaksi Penjualan']))->withInput();
        }
    }
}
