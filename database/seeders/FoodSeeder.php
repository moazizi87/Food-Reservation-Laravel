<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            [
                'category_id' => 1,
                'name' => 'چلو خورشت قیمه',
                'description' => 'برنج ایرانی با خورشت قیمه',
                'price' => 85000,
                'is_available' => true,
                'preparation_time' => 20,
            ],
            [
                'category_id' => 1,
                'name' => 'چلو جوجه کباب',
                'description' => 'برنج ایرانی با جوجه کباب',
                'price' => 95000,
                'is_available' => true,
                'preparation_time' => 25,
            ],
            [
                'category_id' => 2,
                'name' => 'سالاد سزار',
                'description' => 'سالاد سزار با سس مخصوص',
                'price' => 45000,
                'is_available' => true,
                'preparation_time' => 10,
            ],
            [
                'category_id' => 3,
                'name' => 'نوشابه',
                'description' => 'نوشابه خانواده',
                'price' => 15000,
                'is_available' => true,
                'preparation_time' => 1,
            ],
            [
                'category_id' => 4,
                'name' => 'بستنی',
                'description' => 'بستنی وانیلی',
                'price' => 25000,
                'is_available' => true,
                'preparation_time' => 1,
            ],
        ];

        foreach ($foods as $food) {
            Food::create([
                'category_id' => $food['category_id'],
                'name' => $food['name'],
                'slug' => Str::slug($food['name']),
                'description' => $food['description'],
                'price' => $food['price'],
                'is_available' => $food['is_available'],
                'preparation_time' => $food['preparation_time'],
            ]);
        }
    }
} 