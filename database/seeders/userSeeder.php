<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $faker = Faker::create();
        User::factory(300)->create();
        $users = User::all();
        $products = DB::table('products')->get();
        foreach ($users as $user) {
            foreach ($products->random(random_int(4, 20)) as $product) {
                DB::table('saves')->insert(
                    [
                        'user_id' => $user->id,
                        'product_id' => $product->id
                    ]
                );
            }
            foreach ($products->random(random_int(2, 20)) as $product) {
                DB::table('reviews')->insert(
                    [
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'score' => random_int(1, 5),
                        'feedback' => $faker->text()
                    ]
                );
            }
        }
    }
}