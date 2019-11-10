<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
        public function index()
    {
    	$order_item=Order_item::all();
        return $order_item;

    }

    public function show(Order_item $id)
    {
        return $id;

    }
}
