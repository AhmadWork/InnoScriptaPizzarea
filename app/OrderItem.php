<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $table = 'orderables';

    public function orderable()
    {
        return $this->morphTo('orderable');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
