<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class orderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();
        $product_color = DB::table('color_product')->get();

        foreach ($users as $user) {
            for ($i = 0; $i < random_int(0, 5); $i++) {
                DB::table('orders')->insert(
                    [
                        'user_id' => $user->id,
                        'state' => ['en traitment', 'en route', 'livré'][random_int(0, 2)],
                        'wilaya' => $faker->word(),
                        'address' => $faker->address(),
                        'shipment' => $faker->numberBetween(400, 1300),
                        'number' => $faker->phoneNumber(),
                        'name' => $faker->name(),
                        'email' => $faker->email()
                    ]
                );
            }
        }

        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            // $random = random_int(0, 1);
            // if ($random) {
            // $record = $product_color->random();
            // DB::table('order_product_color')->insert(
            //     [
            //         'order_id' => $order->id,
            //         'product_id' => $record->product_id,
            //         'color_id' => $record->color_id,
            //         'quantity' => random_int(1, 3)
            //     ]
            // );
            // } else {
            foreach ($product_color->random(random_int(1, 3)) as $record) {
                DB::table('order_product_color')->insert(
                    [
                        'order_id' => $order->id,
                        'product_id' => $record->product_id,
                        'color_id' => $record->color_id,
                        'quantity' => random_int(1, 3)
                    ]
                );
            }
            // }
        }
    }
}