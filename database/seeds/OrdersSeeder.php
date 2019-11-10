<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\Order;
class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $faker = Faker\Factory::create();

        // Create 30 days of entries for each user.
        foreach ($users as $user) {
            $orders = array();
            $timestamp = Carbon::now();
            for ($d = 0; $d <= 30; $d++) {
                $orders[] = [
                    'user_id' => $user->id,
                    'email' =>$user->email,
                    'items_price'=>123,
                    'created_at' => $timestamp->format('Y-m-d H:i:s'),
                    'updated_at' => $timestamp->format('Y-m-d H:i:s'),
                    'user_id' => $user->id,
                    'address_details' => $faker->sentence(12),
                    'mobile' => '9846378292',
                    'city' => 'munich',
                    'state' => 'Bavaria',
                    'zip' => '80331',
                    'status' => $faker->randomElement(['new', 'delivered'])
                ];
                $timestamp = $timestamp->subDay();
            }

            // Bulk insert generated Order data for each user.
            DB::table('orders')->insert($orders);
        }

        $this->command->info('Orders table seeded.');
    }
}

