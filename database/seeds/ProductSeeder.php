<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create 30 days of entries for each user.
        
            $orders = array();
            $timestamp = Carbon::now();
            for ($d = 0; $d <= 10; $d++) {
                $orders[] = array(
                    'created_at' => $timestamp->format('Y-m-d H:i:s'),
                    'updated_at' => $timestamp->format('Y-m-d H:i:s'),
                    'title' => 'pizza',
                    'desc' => 'pizza is template',
                    'price' => 12,
                    'src' =>'img:1234'
                );
                $timestamp = $timestamp->subDay();
            }

            DB::table('products')->insert($orders);
        

        $this->command->info('Orders table seeded.');
    }
}

