<?php
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create Users.
        $this->call(UserSeeder::class);

        // Create Order data.
        $this->call(OrdersSeeder::class);

        $this->call(ProductSeeder::class);

    }
}
