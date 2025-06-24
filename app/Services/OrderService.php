<?php

namespace App\Services;

use App\Models\Food;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    /**
     * Create a new order.
     *
     * @param array $validatedData
     * @return Order
     * @throws \Exception
     */
    public function createOrder(array $validatedData): Order
    {
        try {
            DB::beginTransaction();

            $total = 0;
            $items = [];

            foreach ($validatedData['items'] as $item) {
                $food = Food::findOrFail($item['food_id']);
                if (!$food->is_available) {
                    throw new \Exception("غذای {$food->name} در حال حاضر موجود نیست.");
                }
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
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'notes' => $validatedData['notes'] ?? null,
            ]);

            $order->items()->createMany($items);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            // Re-throw the exception to be handled by the controller
            throw $e;
        }
    }
} 