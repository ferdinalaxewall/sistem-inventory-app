<?php

namespace App\Http\Controllers\Dashboard\MasterData\Item;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Item\CreateItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;

class ItemController extends Controller
{
    public function index()
    {
        $data = Item::with('category')->latest()->get();
        return view('dashboard.pages.master-data.item.index', compact('data'));
    }

    public function create()
    {
        $title = 'Form Tambah Barang';
        $action_url = route('dashboard.items.item.store');
        $method = 'POST';
        $categories = ItemCategory::orderBy('category_name', 'ASC')->get();
        $data = new Item();

        return view('dashboard.pages.master-data.item.form', compact('title', 'action_url', 'method', 'data', 'categories'));
    }   

    public function store(CreateItemRequest $request)
    {
        $requestDTO = $request->validated();
        try {
            if (empty($requestDTO['code'])) $requestDTO['code'] = (new Item)->generateUniqueCode(Item::UNIQUE_CODE_PREFIX);
            $requestDTO['user_id'] = auth()->user()->uuid;
            Item::create($requestDTO);

            return redirect()->route('dashboard.items.item.index')->with('toastSuccess', __('crud.created', ['name' => 'Barang']));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('dashboard.items.item.create')->with('toastError', __('crud.error_create', ['name' => 'Barang']))->withInput();
        }
    }

    public function edit(string $uuid)
    {
        $data = Item::where('uuid', $uuid)->first();
        if (is_null($data)) return redirect()->route('dashboard.items.item.index')->with('toastError', __('crud.not_found', ['name' => 'Barang']));

        $title = 'Form Edit Barang';
        $action_url = route('dashboard.items.item.update', $uuid);
        $method = 'PUT';
        $categories = ItemCategory::orderBy('category_name', 'ASC')->get();

        return view('dashboard.pages.master-data.item.form', compact("data", 'title', 'action_url', 'method', 'categories'));
    }

    public function update(UpdateItemRequest $request, string $uuid)
    {
        $requestDTO = $request->validated();
        try {
            Item::where('uuid', $uuid)->update($requestDTO);
            return redirect()->route('dashboard.items.item.index')->with('toastSuccess', __('crud.updated', ['name' => 'Barang']));
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.items.item.edit', $uuid)->with('toastError', __('crud.error_update', ['name' => 'Barang']))->withInput();
        }
    }

    public function delete(string $uuid)
    {
        try {
            Item::where('uuid', $uuid)->delete();
            return redirect()->route('dashboard.items.item.index')->with('toastSuccess', __('crud.deleted', ['name' => 'Barang']));
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.items.item.edit', $uuid)->with('toastError', __('crud.error_delete', ['name' => 'Barang']))->withInput();
        }
    }
}
