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
        $pizzas=array(["title"=>"chicken Pizza","desc"=>"our amazing Chicken Pizza","price"=>3.5,"src"=>"https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/190226-buffalo-chicken-pizza-370-1552084943.jpg"],
            ["title"=>"beef Pizza","desc"=>"our amazing beef Pizza","price"=>3.5,"src"=>"https://images-gmi-pmc.edge-generalmills.com/e9cb9507-51e3-4d64-a175-0f2da78f84c5.jpg"],
            ["title"=>"pepperoni Pizza","desc"=>"our amazing pepperoni Pizza","price"=>3,"src"=>"https://www.360bistrobar.com/wp-content/uploads/sites/16/2017/02/pepperoni-pizza.jpg"],
            ["title"=>"Neapolitan Pizza","desc"=>"our amazing Neapolitan Pizza","price"=>3,"src"=>"https://www.mklibrary.com/wp-content/uploads/2018/05/Neapolitan-Style-Margherita-Pizza-featured.jpg"],
            ["title"=>"Sicilian Pizza","desc"=>"our amazing Sicilian Pizza","price"=>4.5,"src"=>"https://www.seriouseats.com/images/2016/05/20160503-spicy-spring-pizza-primary.jpg"],
            ["title"=>"California Pizza","desc"=>"our amazing California Pizza","price"=>3.5,"src"=>"https://mms.businesswire.com/media/20190319005797/en/711410/5/CPK_Spicy_Milano_Pizza.jpg"],
            ["title"=>"Kebab Pizza","desc"=>"our amazing Kebab Pizza","price"=>3.5,"src"=>"https://www.cookhalaal.com/wp-content/uploads/2018/10/KebabPizza-original.jpg"],
            ["title"=>"Margherita Pizza","desc"=>"our amazing Margherita Pizza","price"=>2.5,"src"=>"https://cdn.apartmenttherapy.info/image/fetch/f_jpg,q_auto:eco,c_fill,g_auto,w_1500,ar_1:1/https%3A%2F%2Fstorage.googleapis.com%2Fgen-atmedia%2F3%2F2012%2F07%2Fb36036a54e1cf9c084f4b702a63e5a08f1e98983.jpeg"],
            ["title"=>"Veggie Pizza","desc"=>"our amazing Veggie Pizza","price"=>3.5,"src"=>"https://www.archanaskitchen.com/images/archanaskitchen/1-Author/Waagmi_Soni/Gralic_Crust_Veggie_Pizza.jpg"],
            ["title"=>"Hawaiian Pizza","desc"=>"our so average Hawaiian Pizza","price"=>3.5,"src"=>"https://res.cloudinary.com/droz/image/upload/v1558317957/prod-store/gallery/slides/Hawaiian-pizza-pie-pineapple-720.jpg"],
            );
            $orders = array();
            $timestamp = Carbon::now();
            foreach ($pizzas as $pizza) {
                $orders[] = array(
                    'created_at' => $timestamp->format('Y-m-d H:i:s'),
                    'updated_at' => $timestamp->format('Y-m-d H:i:s'),
                    'title' => $pizza['title'],
                    'desc' => $pizza['desc'],
                    'price' => $pizza['price'],
                    'src' =>$pizza['src']
                );
                $timestamp = $timestamp->subDay();
            }

            DB::table('products')->insert($orders);
        

        $this->command->info('Orders table seeded.');
    }
}

