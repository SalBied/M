<?php
namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemService
{
    public function createItem(array $data, $request)
    {


        // Create the item
        $item = Item::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'condition' => $request->condition,
            'seller_id' => Auth::id()
        ]);


        // Handle file uploads if photos are provided
        if ($request->hasFile('photos')) {

            foreach ($request->file('photos') as $photo) {
                // Store each photo in the public storage and get the path
                $path = $photo->store('photos', 'public');

                // Save the photo path in the item_photos table
                $item->photos()->create([
                    'photo_path' => $path,
                ]);
            }
        }

        return $item;
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
        $item->load('seller', 'category','photos');

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
