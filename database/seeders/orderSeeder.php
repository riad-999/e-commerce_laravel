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
                $total = random_int(2000, 5000);
                DB::table('orders')->insert(
                    [
                        'user_id' => $user->id,
                        'state' => ['en traitment', 'en route', 'livré'][random_int(0, 2)],
                        'wilaya' => $faker->word(),
                        'address' => $faker->address(),
                        'shipment' => $faker->numberBetween(400, 1300),
                        'total' => $total,
                        'number' => $faker->phoneNumber(),
                        'name' => $faker->name(),
                        'email' => $faker->email(),
                        'track_code' => [null, $faker->text(30)][random_int(0, 1)]
                    ]
                );
            }
        }

        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            foreach ($product_color->random(random_int(1, 3)) as $record) {
                $rand = random_int(1, 3);
                DB::table('order_product_color')->insert(
                    [
                        'order_id' => $order->id,
                        'product_id' => $record->product_id,
                        'color_id' => $record->color_id,
                        'quantity' => $rand,
                        'total' => random_int(1000, 5000) * $rand
                    ]
                );
            }
            // }
        }
    }
}