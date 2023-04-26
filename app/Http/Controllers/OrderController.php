<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function create()
    {
        // What things To Take For "CREATE" ?? 
        // userNames 
        // 
        $customers = User::where('userable_type', 'App\Models\Customer')->get();
        $allMedicines  = Medicine::get();
        return view('order.create', compact(['customers', 'allMedicines']));
    }


    public function store(Request $request)
    {
        // What To send And What to Recieve ??? 
        // dd($request->all());
        $medArray = $request->medicines;
        $quantArray = $request->quantities;
        $priceArray = $request->prices;
        $typeArray = $request->types;
        $totalPrice = 0;
        $spsLineItems = [];
        $stripe = new StripeClient(env('STRIPE_SECRET')); // 1- Create the CLient 

        $orderID  = 4;
        for ($i = 0; $i < sizeof($medArray); $i++) {
            // TODO Calcualte TOtal Here and Put it >> Quanttiy * No.Items
            $spsLineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $medArray[$i],
                    ],
                    'unit_amount' => $priceArray[$i], // Price Is In CENTS , if we Make it Other Number We will Need to Multiply By 100
                ],
                'quantity' => $quantArray[$i],
            ];
        }
        // 2 - Create the "Session " 
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $spsLineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success', [], true) . "?orderID=$orderID",
            'cancel_url' => route('stripe.cancel', [], true),
        ]);


        // todo >>  SAVE THE Order Here and Make New Model instance 
        // Put the Status > Uncofirmed TIll the Success 
        // TODO Sqlite instead of All those Problems ; 

        // $newOrder  = new Order() ; 
        // $newOrder->status  = "NEW" ; 
        // $newOrder->stripe_session_id  =  $checkout_session->id  ; 
        // And So on ...

        // 4242424242424242	Succeeds and immediately processes the payment.
        // 4000000000003220	Complete 3D Secure 2 authentication for a successful payment.
        // 4000000000009995	Always fails with a decline code of insufficient_funds.


        return redirect($checkout_session->url); // 3- Redirect 
    }


    public function success()
    {
        // Here i Should Change the Order Status To Delivered   ;
        $letId  = request()->orderID;
        return "This is the Id : $letId";
    }

    public function cancel()
    {
        // If He Clicks Back On the Left Button He Will Redirect to this  ;
        // Here i Should Keep the Status Of the Order   ;
        return "EEERRR";
    }


    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
