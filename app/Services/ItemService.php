<?php
namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemService
{
    public function createItem(array $data)
    {
        $data['seller_id'] = Auth::id();
        return Item::create($data);
    }

    public function updateItem(Item $item, array $data)
    {
        return $item->update($data);
    }

    public function deleteItem(Item $item)
    {
        return $item->delete();
    }

    public function getItemsWithCategoryFilter($categoryId = null)
    {
        $query = Item::with('category');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->get();
    }
    public function show(Item $item){
        $item->load('seller', 'category');

        $similarItems = Item::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->take(5)
            ->get();

        return response()->json([
            'item' => $item,
            'similar_items' => $similarItems
        ]);

    }
}
