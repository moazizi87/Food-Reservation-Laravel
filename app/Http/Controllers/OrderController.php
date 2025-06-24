<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::with(['user', 'items.food'])
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
    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request->validated());

            return redirect()->route('orders.show', $order)
                ->with('success', 'سفارش با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'خطا در ثبت سفارش: ' . $e->getMessage()]);
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
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'سفارش با موفقیت حذف شد.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);
        
        $validated = $request->validate([
            'status' => 'required|in:preparing,ready,delivered,cancelled',
        ]);

        $updateData = $validated;

        if ($validated['status'] === 'preparing') {
            $updateData['preparation_time'] = now();
        } elseif ($validated['status'] === 'delivered') {
            $updateData['delivery_time'] = now();
        }

        $order->update($updateData);

        return back()->with('success', 'وضعیت سفارش با موفقیت بروزرسانی شد.');
    }
}
