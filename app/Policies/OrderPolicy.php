<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Order $order)
    {
        return $user->isAdmin() || $user->student->id === $order->student_id;
    }

    public function create(User $user)
    {
        return $user->isStudent();
    }

    public function update(User $user, Order $order)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Order $order)
    {
        return $user->isAdmin();
    }
} 