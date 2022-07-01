<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            productSeeder::class,
            userSeeder::class,
            orderSeeder::class
        ]);
        // $brands = Brand::factory(20)->create();
        // $categories = Category::factory(10)->create();
        // $colors = Color::factory(20)->create();
        // for ($i = 0; $i <= 300; $i++) {
        //     Product::factory()->for($brands->random(1))
        //         ->for($categories->random(1))
        //         ->hasAttached($colors->random(random_int(1, 6)))
        //         ->create();
        // }

        // User::factory(50)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $users = User::all();
        // $products = Product::all();
        // foreach ($users as $user) {
        //     Order::factory()->count(random_int(1, 4))
        //         ->for($user)
        //         ->hasAttached($products->random(random_int(1, 3)));


        //     for ($j = 1; $j <= random_int(1, 4); $j++) {
        //         User::factory()
        //             ->has(Order::factory()
        //                 ->hasAttached($products->random(random_int(1, 3))));
        //     }
        // }
        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin')
        // ]);
    }
}