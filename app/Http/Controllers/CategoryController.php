<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Laravel\Reverb\Loggers\Log;

class CategoryController extends Controller
{
    public function index()
    {    Log::info('An informational message.');
        return response()->json(Category::all());
    }

    public function getItemsByCategory(Category $category)
    {
        $categoryItems = Item::where('category_id' , $category->id)->get();
        return response()->json($categoryItems);
    }
}
