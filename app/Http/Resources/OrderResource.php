<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResouce;
use App\Custom\Hasher;

class OrderResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'created_at' => (string)$this->created_at->toDateTimeString(),
            'updated_at' => (string)$this->updated_at->toDateTimeString(),
            'id' => $this->id,
            'user_id' => Hasher::encode($this->user_id),
            'items_price' => $this->items_price,
            'mobile' => $this->mobile,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'status' => $this->status,
        ];
    }
}
