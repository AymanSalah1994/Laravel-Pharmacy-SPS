<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Prescription;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return OrderResource::collection($orders);
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->is_insured = $request->input('is_insured');
        $order->delivering_address_id = $request->input('delivering_address_id');
        $order->user_id = '4';
        // TODO
        // $order->user_id = $request->input() ;
        $order->status = 'New';
        // TODO
        // Save and Get ID to Loop For Images 
        $order->save();
        $order_id = $order->id;

        if ($request->hasFile('prescriptions')) {

            $file = $request->file('prescriptions');
            // TODO : 
            // Multiple Images and Validation 
            $prescription = new Prescription();
            $prescription->order_id = $order_id;
            $prescription->pre_image = 'pres-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $prescription->pre_image);
            $prescription->save();
        }
        return new OrderResource($order);
    }


    public function show($id)
    {
        $or = Order::find($id);
        if ($or) {
            return new OrderResource($or);
        } else {
            return response()->json([
                'message' => 'order not found'
            ]);
        }
    }

    // TODO > Update 
    
}
