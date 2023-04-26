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
        $user = auth('sanctum')->user();

        $request->validate([
            'is_insured' => ['required', 'boolean'],
            'delivering_address_id' => ['required', 'exists:user_addresses,id'],
            'prescriptions.*' => ['required', 'image', 'max:2048'],
        ]);

        $order = new Order();
        $order->is_insured = $request->input('is_insured');
        $order->delivering_address_id = $request->input('delivering_address_id');
        $order->user_id = $user->id;
        $order->status = 'New';
        $order->save();
        $order_id = $order->id;

        if ($request->hasFile('prescriptions')) {
            $files = $request->file('prescriptions');
            foreach ($files as $file) {
                $prescription = new Prescription();
                $prescription->order_id = $order_id;
                $prescription->pre_image = 'pres-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('images', $prescription->pre_image);
                $prescription->save();
            }
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
