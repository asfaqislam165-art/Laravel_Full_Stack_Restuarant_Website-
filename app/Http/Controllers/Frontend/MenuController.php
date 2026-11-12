<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->with(['menuItems' => function ($query) use ($request) {
                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                          ->orWhere('description', 'like', '%' . $request->search . '%');
                }
            }])
            ->get();

        return view('frontend.menu', compact('categories'));
    }

    public function show(MenuItem $menuItem)
    {
        $relatedItems = MenuItem::where('category_id', $menuItem->category_id)
            ->where('id', '!=', $menuItem->id)
            ->where('is_available', true)
            ->take(3)
            ->get();

        return view('frontend.menu-detail', compact('menuItem', 'relatedItems'));
    }
}