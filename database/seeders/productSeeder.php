<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 8; $i++) {
            DB::table('categories')->insert(
                [
                    'name' => $faker->unique()->word(),
                    'description' => $faker->text()
                ]
            );
        }
        for ($i = 0; $i < 15; $i++) {
            DB::table('brands')->insert(
                [
                    'name' => $faker->unique()->word()
                ]
            );
        }
        for ($i = 0; $i < 20; $i++) {
            DB::table('colors')->insert(
                [
                    'name' => $faker->unique()->word(),
                    'value' => $faker->hexColor()
                ]
            );
        }

        $brands = DB::table('brands')->get();
        $categories = DB::table('categories')->get();
        foreach ($brands as $brand) {
            foreach ($categories as $category) {
                for ($i = 0; $i < random_int(5, 10); $i++) {
                    $price = $faker->numberBetween(1000, 5000);
                    $rand = random_int(0, 1);
                    $promo = $rand ? $price - $price * random_int(1, 5) * 10 / 100 : null;
                    DB::table('products')->insert(
                        [
                            'brand_id' => $brand->id,
                            'category_id' => $category->id,
                            'name' => $faker->text(16),
                            'price' => $price,
                            'promo' => $promo,
                        ]
                    );
                }
            }
        }

        $products = DB::table('products')->get();
        $colors = DB::table('colors')->get();
        foreach ($products as $product) {
            $random_colors = $colors->random(random_int(1, 6));
            foreach ($random_colors as $color) {
                DB::table('color_product')->insert(
                    [
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'quantity' => random_int(30, 100),
                        'main_image' => $faker->imageUrl()
                    ]
                );
            }
        }

        $product_color = DB::table('color_product')->get();
        foreach ($product_color as $record) {
            for ($i = 0; $i < random_int(3, 8); $i++) {
                DB::table('products_images')->insert(
                    [
                        'product_id' => $record->product_id,
                        'color_id' => $record->color_id,
                        'url' => $faker->imageUrl()
                    ]
                );
            }
        }
    }
}