<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Custom\Hasher;
use App\Http\Controllers\APIController;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Order;
use App\OrderItem;
use App\Product;
use Carbon\Carbon;
class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get user from $request token.
        if (! $user = auth()->setRequest($request)->user()) {
            return $this->responseUnauthorized();
        }

        $collection = Order::where('user_id', $user->id);

        // Check query string filters.
        if ($status = $request->query('status')) {
            if ('new' === $status || 'delivered' === $status) {
                $collection = $collection->where('status', $status);
            }
        }

        $collection = $collection->latest()->paginate();

        // Appends "status" to pagination links if present in the query.
        if ($status) {
            $collection = $collection->appends('status', $status);
        }

        return new OrderCollection($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        info('This is some useful information.');
        if (! $user = auth()->setRequest($request)->user()) {
            return $this->responseUnauthorized();
        }


     
        $orderItems = collect([]);
        $itemsPrice = 0;
        
        $orderItem=[];
 
    

  
        foreach ($request->cart as $item) {
         
            $unit_price     = Product::find($item['id'])->price;
            $itemsPrice +=$unit_price *  $item['quantity'];

        }

           // Warning: Data isn't being fully sanitized yet.
       
           $orderf= [
            'user_id' => $user->id,
            'email' =>$user->email,
            'items_price'=>$itemsPrice,
            'user_id' => $user->id,
            'address_details' => $request->address,
            'mobile' => '9846378292',
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'status' => 'new', 
            ];
            $order =new Order($orderf);
$order->save();

return $order;

        foreach ($request->cart as $item) {
            $itemf=[
                'user_id'=>$user->id,
                'product_id'=>$order->id,
                'count'=>$item['count']
    
            ];
       $orderItems.push($item);
        }
        
        /*  
        $order= new Order;
            $order->user_id         = $user->id;
            $order->items_price     = $orderItems;
            $order->address_details = $request->address;
            $order->email           = $user->email;
            $order->mobile          = '938476372';
            $order->city_name       = $request->city;
            $order->state           = $request->state;
            $order->zip             = $request->zip;
    
            $order->save();
           
            $order->orderItems()->saveMany($orderItems);
           try{
            return response()->json([
                'status' => 201,
                'message' => 'Resource created.',
                'id' => $order->id
            ], 201);
        } catch (Exception $e) {
            return $this->responseServerError('Error creating resource.');
        }
        
        return $order;
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get user from $request token.
        if (! $user = auth()->setRequest($request)->user()) {
            return $this->responseUnauthorized();
        }

        // User can only acccess their own data.
        if ($order->user_id === $user->id) {
            return $this->responseUnauthorized();
        }

        $order = Order::where('id', $id)->firstOrFail();
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get user from $request token.
        if (! $user = auth()->setRequest($request)->user()) {
            return $this->responseUnauthorized();
        }

        // Validates data.
        $validator = Validator::make($request->all(), [
            'value' => 'string',
            'status' => 'in:new,delivered',
        ]);

        if ($validator->fails()) {
            return $this->responseUnprocessable($validator->errors());
        }

        try {
            $order = Order::where('id', $id)->firstOrFail();
            if ($order->user_id === $user->id) {
                if (request('value')) {
                    $order->value = request('value');
                }
                if (request('status')) {
                    $order->status = request('status');
                }
                $order->save();
                return $this->responseResourceUpdated();
            } else {
                return $this->responseUnauthorized();
            }
        } catch (Exception $e) {
            return $this->responseServerError('Error updating resource.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Get user from $request token.
        if (! $user = auth()->setRequest($request)->user()) {
            return $this->responseUnauthorized();
        }

        $order = Order::where('id', $id)->firstOrFail();

        // User can only delete their own data.
        if ($order->user_id !== $user->id) {
            return $this->responseUnauthorized();
        }

        try {
            $order->delete();
            return $this->responseResourceDeleted();
        } catch (Exception $e) {
            return $this->responseServerError('Error deleting resource.');
        }
    }
}
