<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */




  
    protected $fillable = [
        'items_price',
        'address_details',
        'email',
        'mobile',
        'city',
        'state',
        'zip',
        'user_id'
      
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * A Order belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
 
}
