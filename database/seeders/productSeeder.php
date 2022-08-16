<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DateTime;
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
        for ($i = 0; $i < 25; $i++) {
            $value2 = [0, 0, 0, 1][random_int(0, 3)] ? $faker->hexColor() : null;
            $value3 = [0, 1][random_int(0, 1)] ? $faker->hexColor() : null;
            DB::table('colors')->insert(
                [
                    'name' => $faker->unique()->word(),
                    'value1' => $faker->hexColor(),
                    'value2' => $value2,
                    'value3' => $value2 ? $value3 : null
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
                    $expires = null;
                    if ($promo) {
                        if (random_int(0, 2)) {
                            $date = $faker->dateTimeBetween('+1 hour', '+3 day')->format('Y-m-d');
                            $date = new DateTime($date);
                            $expires = $date->format('Y-m-d');
                        }
                    }
                    DB::table('products')->insert(
                        [
                            'brand_id' => $brand->id,
                            'category_id' => $category->id,
                            'name' => $faker->text(16),
                            'price' => $price,
                            'description' => $faker->text(300),
                            'promo' => $promo,
                            'expires' => $expires,
                            'created_at' => $faker->dateTimeBetween(
                                $faker->dateTimeBetween('-1 year')->format('Y-m-d H:i:s'),
                                now()
                            )
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
                $rand = random_int(1, 30000);
                DB::table('color_product')->insert(
                    [
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'quantity' => random_int(30, 100),
                        'main_image' => "https://picsum.photos/640/480?random=$rand"
                    ]
                );
            }
        }

        $product_color = DB::table('color_product')->get();
        foreach ($product_color as $record) {
            for ($i = 0; $i < random_int(3, 8); $i++) {
                $rand = random_int(1, 30000);
                DB::table('products_images')->insert(
                    [
                        'product_id' => $record->product_id,
                        'color_id' => $record->color_id,
                        'image' => "https://picsum.photos/640/480?random=$rand"
                    ]
                );
            }
        }
    }
}