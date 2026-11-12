<?php
// app/Http/Controllers/Admin/MenuItemController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{
    public function index()
    {
        $items = MenuItem::with('category')->latest()->paginate(15);
        return view('admin.menu-items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'prep_time' => 'nullable|string|max:50',
            'dietary_tags' => 'nullable|string|max:150',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_popular'] = $request->boolean('is_popular');
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu', 'public');
        }
        MenuItem::create($data);
        return redirect()->route('admin.menu-items.index')->with('success', 'Dish added to menu.');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = Category::all();
        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'prep_time' => 'nullable|string|max:50',
            'dietary_tags' => 'nullable|string|max:150',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_popular'] = $request->boolean('is_popular');
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($menuItem->image) Storage::disk('public')->delete($menuItem->image);
            $data['image'] = $request->file('image')->store('menu', 'public');
        }
        $menuItem->update($data);
        return redirect()->route('admin.menu-items.index')->with('success', 'Dish updated.');
    }

    public function destroy(MenuItem $menuItem)
    {
        if ($menuItem->image) Storage::disk('public')->delete($menuItem->image);
        $menuItem->delete();
        return back()->with('success', 'Dish deleted.');
    }
}