<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Food::class);
        $foods = Food::with('category')->latest()->paginate(10);
        return view('foods.index', compact('foods'));
    }

    public function menu()
    {
        $categories = Category::with(['foods' => function ($query) {
            $query->where('is_available', true);
        }])->where('is_active', true)->get();
        
        return view('foods.menu', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Food::class);
        $categories = Category::where('is_active', true)->get();
        return view('foods.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Food::class);
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'preparation_time' => 'required|integer|min:1',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($validated);

        return redirect()->route('foods.index')
            ->with('success', 'غذا با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        $this->authorize('view', $food);
        return view('foods.show', compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        $this->authorize('update', $food);
        $categories = Category::where('is_active', true)->get();
        return view('foods.edit', compact('food', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Food $food)
    {
        $this->authorize('update', $food);
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'preparation_time' => 'required|integer|min:1',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($validated);

        return redirect()->route('foods.index')
            ->with('success', 'غذا با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        $this->authorize('delete', $food);
        $food->delete();

        return redirect()->route('foods.index')
            ->with('success', 'غذا با موفقیت حذف شد.');
    }
}
