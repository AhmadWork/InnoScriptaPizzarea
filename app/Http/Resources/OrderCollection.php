<?php

namespace App\Http\Resources;

use App\Order;
use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\OrderResource;

class OrderCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Transforms the collection to match format in OrderResource.
        $this->collection->transform(function (Order $Order) {
            return (new OrderResource($Order));
        });

        return parent::toArray($request);
    }
}
