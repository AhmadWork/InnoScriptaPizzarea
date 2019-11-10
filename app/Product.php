<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Product extends Model
{



    protected $fillable = [
        'title',
        'desc',
        'price',
        'src'
      
    ];
  

 
}
