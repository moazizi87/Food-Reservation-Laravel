<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Food;
use App\Models\Order;
use App\Policies\CategoryPolicy;
use App\Policies\FoodPolicy;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Food::class => FoodPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
} 