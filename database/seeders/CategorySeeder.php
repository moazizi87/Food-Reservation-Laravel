<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'غذاهای اصلی',
                'description' => 'انواع غذاهای اصلی و گرم',
                'is_active' => true,
            ],
            [
                'name' => 'پیش غذا',
                'description' => 'انواع پیش غذا و سالاد',
                'is_active' => true,
            ],
            [
                'name' => 'نوشیدنی',
                'description' => 'انواع نوشیدنی‌های سرد و گرم',
                'is_active' => true,
            ],
            [
                'name' => 'دسر',
                'description' => 'انواع دسر و شیرینی',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }
    }
} 