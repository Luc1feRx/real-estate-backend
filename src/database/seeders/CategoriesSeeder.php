<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homeSale = Category::create([
            'name' => 'Nhà đất bán',
            'slug' => 'nha-dat-ban',
            'image' => 'https://images.pexels.com/photos/235986/pexels-photo-235986.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500'
        ]);

        Category::create([
            'name' => 'Bán nhà riêng',
            'slug' => 'ban-nha-rieng',
            'parent_id' => $homeSale->id,
            'image' => 'https://anhdephd.vn/wp-content/uploads/2022/05/background-dep.jpg'
        ]);

        Category::create([
            'name' => 'Bán căn hộ chung cư',
            'slug' => 'ban-can-ho-chung-cu',
            'parent_id' => $homeSale->id,
            'image' => 'https://anhdephd.vn/wp-content/uploads/2022/05/background-dep.jpg'
        ]);

        $homeRentals = Category::create([
            'name' => 'Nhà đất cho thuê',
            'slug' => 'nha-dat-cho-thue',
            'image' => 'https://images.pexels.com/photos/235986/pexels-photo-235986.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500'
        ]);

        Category::create([
            'name' => 'Cho thuê nhà riêng',
            'slug' => 'cho-thue-nha-rieng',
            'parent_id' => $homeRentals->id,
        ]);

        Category::create([
            'name' => 'Cho thuê căn hộ chung cư',
            'slug' => 'cho-thue-can-ho-chung-cu',
            'parent_id' => $homeRentals->id,
        ]);
    }
}
