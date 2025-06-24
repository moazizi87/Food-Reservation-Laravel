<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    // Only admin can see the list of all orders.
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    // Admin can see any order, students can only see their own.
    public function view(User $user, Order $order): bool
    {
        return $user->hasRole('admin') || $order->user_id === $user->id;
    }

    // Only students can create an order.
    public function create(User $user): bool
    {
        return $user->hasRole('student');
    }

    // Only admin can update an order.
    public function update(User $user, Order $order): bool
    {
        return $user->hasRole('admin');
    }

    // Only admin can delete an order.
    public function delete(User $user, Order $order): bool
    {
        return $user->hasRole('admin');
    }

    // Only admin can update the status of an order.
    public function updateStatus(User $user, Order $order): bool
    {
        return $user->hasRole('admin');
    }
}