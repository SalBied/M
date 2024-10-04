<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\ItemService;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;


class ItemController extends Controller

{
    use AuthorizesRequests;
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        return response()->json($this->itemService->getItemsWithCategoryFilter($categoryId));
    }

    public function store(StoreItemRequest $request)
    {
        return response()->json($this->itemService->createItem($request->validated()), 201);
    }

    public function show(Item $item)
    {
        return response()->json($this->itemService->show($item));
    }

    public function update(UpdateItemRequest $request, Item $item)
    {

        $this->authorize('update', $item);
        return response()->json($this->itemService->updateItem($item, $request->validated()));
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $this->itemService->deleteItem($item);
        return response()->json(['message' => 'Item deleted'], 200);
    }
}
