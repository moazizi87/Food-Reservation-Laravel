<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['student', 'foods'])
            ->when(Auth::user()->isStudent(), function ($query) {
                return $query->where('student_id', Auth::user()->student->id);
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
        $foods = Food::where('status', 'active')
            ->where('available_quantity', '>', 0)
            ->get();
        return view('orders.create', compact('foods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'foods' => 'required|array',
            'foods.*.id' => 'required|exists:foods,id',
            'foods.*.quantity' => 'required|integer|min:1',
            'reservation_date' => 'required|date|after:today',
            'notes' => 'nullable|string'
        ]);

        $total_amount = 0;
        $order_items = [];

        foreach ($validated['foods'] as $item) {
            $food = Food::findOrFail($item['id']);
            
            if ($food->available_quantity < $item['quantity']) {
                return back()->withErrors(['foods' => 'موجودی کافی برای ' . $food->name . ' وجود ندارد.']);
            }

            $total_amount += $food->price * $item['quantity'];
            $order_items[$food->id] = [
                'quantity' => $item['quantity'],
                'price' => $food->price
            ];

            $food->decrement('available_quantity', $item['quantity']);
        }

        $order = Order::create([
            'student_id' => Auth::user()->student->id,
            'total_amount' => $total_amount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'reservation_date' => $validated['reservation_date'],
            'notes' => $validated['notes']
        ]);

        $order->foods()->attach($order_items);

        return redirect()->route('orders.index')
            ->with('success', 'سفارش شما با موفقیت ثبت شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
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
        $this->authorize('update', $order);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order)
            ->with('success', 'وضعیت سفارش با موفقیت بروزرسانی شد.');
    }
}
