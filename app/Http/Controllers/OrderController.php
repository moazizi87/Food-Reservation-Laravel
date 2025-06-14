<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'items.food'])
            ->when(auth()->user()->hasRole('student'), function ($query) {
                return $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $foods = Food::where('is_available', true)->get();
        return view('orders.create', compact('foods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            $items = [];

            foreach ($validated['items'] as $item) {
                $food = Food::findOrFail($item['food_id']);
                $subtotal = $food->price * $item['quantity'];
                $total += $subtotal;

                $items[] = [
                    'food_id' => $food->id,
                'quantity' => $item['quantity'],
                    'price' => $food->price,
                    'notes' => $item['notes'] ?? null,
                ];
        }

        $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'notes' => $validated['notes'] ?? null,
        ]);

            $order->items()->createMany($items);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'سفارش با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'خطا در ثبت سفارش. لطفا دوباره تلاش کنید.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['user', 'items.food']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);
        
        $validated = $request->validate([
            'status' => 'required|in:preparing,ready,delivered,cancelled',
        ]);

        $order->update($validated);

        if ($validated['status'] === 'preparing') {
            $order->update(['preparation_time' => now()]);
        } elseif ($validated['status'] === 'delivered') {
            $order->update(['delivery_time' => now()]);
        }

        return back()->with('success', 'وضعیت سفارش با موفقیت بروزرسانی شد.');
    }
}
