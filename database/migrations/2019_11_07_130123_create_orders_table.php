<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->decimal('items_price');
            $table->string('address_details');
            $table->string('email');
            $table->string('mobile');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->enum('status', ['delivered', 'new'])->default('new');
            $table->integer('user_id');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
