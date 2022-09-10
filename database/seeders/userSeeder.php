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
        $wilayas = json_decode(
            file_get_contents(
                storage_path() . "/app/wilayas.json"
            )
        );
        $faker = Faker::create();
        $now = now();
        foreach ($wilayas as $wilaya) {
            DB::table('wilayas')->insert([
                'id' => $wilaya->code,
                'name' => $wilaya->name,
                'home_shipment' => str_replace('da', '', $wilaya->home),
                'desk_shipment' => $wilaya->desk ? str_replace('da', '', $wilaya->desk) : null,
                'duration' => $wilaya->duration
            ]);
        }
        for ($i = 1; $i <= 300; $i++) {
            $id = DB::table('users')->insertGetId([
                'name' => $faker->name(),
                'password' => bcrypt('laravel_user'),
                'email' => $faker->email(),
                'created_at' => $now,
                'updated_at' => $now
            ]);
            DB::table('users_addresses')->insert([
                'user_id' => $id,
                'wilaya_id' => $wilayas[random_int(0, 49)]->code,
                'address' => $faker->address(),
                'number' => $faker->numerify('##########'),
            ]);
        }
        DB::table('users')->insert([
            'name' => 'riad felih',
            'password' => bcrypt('capcom'),
            'email' => 'felihriad5@gmail.com',
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'password' => bcrypt('admin147'),
            'email' => 'felihriad4@gmail.com',
            'is_admin' => true,
            'is_privileged' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
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
                        'feedback' => $faker->text(),
                        'created_at' => $faker->dateTimeBetween('-1 year', now())
                            ->format('Y-m-d H:i:s')
                    ]
                );
            }
        }
    }
}