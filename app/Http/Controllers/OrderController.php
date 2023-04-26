<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allOrders = Order::query();
            if ($request->searchkeyWord) {
                $allOrders = $allOrders->where('name', 'LIKE', "%Prof%");
                // {$request->searchkeyWord}
            }
            $allOrders = $allOrders->get();
            return DataTables::of($allOrders)
                ->addColumn('action', function ($allOrders) {
                    $showLink  = route('orders.show', $allOrders->id);
                    $editLink  = route('orders.edit', $allOrders->id);
                    $deleteLink  = route('orders.destroy', $allOrders->id);
                    $myField = csrf_field();
                    $myToken = csrf_token();
                    $DEL = $myField . "<input type=\"hidden\" name=\"_method\" value=\"DELETE\"> ";


                    $newControles  = "<a href=$showLink class=\"btn btn-primary\" >Show/Process</a>"; // Only To see 

                    $processingControles = "
                    <a href=$showLink class=\"btn btn-primary\" >Show</a>
                        <a href=$editLink class=\"btn btn-warning\" >Handle/Edit</a>
                        <a onclick=\"myFunction($allOrders->id , '$myToken' ) \" class=\"btn btn-danger\">
                        Delete
                        </a>
                        <form id=$allOrders->id action=$deleteLink method='POST'
                            style=display: hidden class='form-inline'>
                            $DEL
                        </form>";


                    $waitingConfirmationControls  = "Waiting For Confirmation";
                    $canceledControls  = "Canceled";
                    $confirmedControls  = "<a href=$showLink class=\"btn btn-primary\" >Confirmed/Mark as Delivered</a>";
                    $deliveredControles  = "Delivered";

                    if ($allOrders->status == "New") {
                        return $newControles;
                    } else if ($allOrders->status == "Processing") {
                        return $processingControles;
                    } else if ($allOrders->status == "Delivered") {
                        return $deliveredControles;
                    } else if ($allOrders->status == "WaitingForUserConfirmation") {
                        return $waitingConfirmationControls;
                    } else if ($allOrders->status == "Canceled") {
                        return $canceledControls;
                    } else if ($allOrders->status == "Confirmed") {
                        return $confirmedControls;
                    }


                    // return
                    //     "<a href=$showLink class=\"btn btn-primary\" >Show</a>
                    //     <a href=$editLink class=\"btn btn-warning\" >Edit</a>
                    //     <a onclick=\"myFunction($allOrders->id , '$myToken' ) \" class=\"btn btn-danger\">
                    //     Delete
                    //     </a>
                    //     <form id=$allOrders->id action=$deleteLink method='POST'
                    //         style=display: hidden class='form-inline'>
                    //         $DEL
                    //     </form>";
                })
                ->addColumn('testingName', function ($allOrders) {
                    $doc  = User::find($allOrders->user_id);
                    $theName  = $doc->name;
                    return  "$theName";
                })
                ->make(true);
        }
        return view('order.index');
    }

    public function create()
    {
        $customers = User::where('userable_type', 'App\Models\Customer')->get();
        $allMedicines  = Medicine::get();
        return view('order.create', compact(['customers', 'allMedicines']));
    } // Create Ok 

    public function store(OrderRequest $request)
    {
        $medArray = $request->medicines;
        $quantArray = $request->quantities;
        $priceArray = $request->prices;
        $typeArray = $request->types;
        $bigArray  = [$medArray, $quantArray, $priceArray, $typeArray];
        $sizeFlag  = false;
        $initialSize = sizeof($medArray);

        foreach ($bigArray as $arr) {
            if (sizeof($arr) != $initialSize) {
                $sizeFlag = true;
            }
        }

        if ($sizeFlag) {
            return redirect()->route('orders.create')->with('error', ' Sometyhing Wrong');
        }

        // else  is Below : 
        $totalPrice = 0;
        $spsLineItems = [];
        $stripe = new StripeClient(env('STRIPE_SECRET')); // 1- Create the CLient 
        for ($i = 0; $i < sizeof($medArray); $i++) {
            // TODO Calcualte TOtal Here and Put it >> Quanttiy * No.Items
            $totalPrice = $totalPrice + ($priceArray[$i] * $quantArray[$i]);  //TODO
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

        $newOrder = new Order();
        $newOrder->status  = "New";
        $newOrder->user_id =  auth()->user()->id; // creator_id
        $newOrder->customer_id = $request->customer_id;
        $newOrder->delivering_address_id = "1"; // TODO 
        $newOrder->is_insured = true;  // TODO 
        $newOrder->total_price = $totalPrice / 100;
        $newOrder->save();
        $orderID = $newOrder->id;


        // TODO Sqlite instead of All those Problems ; 

        for ($i = 0; $i < sizeof($medArray); $i++) {
            if (is_numeric($medArray[$i])) {
                $orderMedicine  =  new OrderMedicine();
                $orderMedicine->order_id = $orderID;
                $orderMedicine->medicine_id =  $medArray[$i];
                $orderMedicine->type =  $typeArray[$i];
                $orderMedicine->quantity =  $quantArray[$i];
                $orderMedicine->price = $priceArray[$i];
                $orderMedicine->save();
            } else {
                $newlyCreatedMedicine  = new Medicine();
                $newlyCreatedMedicine->name  = $medArray[$i];
                $newlyCreatedMedicine->price = $priceArray[$i];
                $newlyCreatedMedicine->save();
                $newMedId  = $newlyCreatedMedicine->id;
                // Save 
                $orderMedicine  =  new OrderMedicine();
                $orderMedicine->order_id = $orderID;
                $orderMedicine->medicine_id =  $newMedId;
                $orderMedicine->type =  $typeArray[$i];
                $orderMedicine->quantity =  $quantArray[$i];
                $orderMedicine->price = $priceArray[$i];
                $orderMedicine->save();
            }
        }
        // 4242424242424242	Succeeds and immediately processes the payment.
        // 4000000000003220	Complete 3D Secure 2 authentication for a successful payment.
        // 4000000000009995	Always fails with a decline code of insufficient_funds.
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $spsLineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success', [], true) . "?orderID=$orderID",
            'cancel_url' => route('stripe.cancel', [], true),
        ]);
        return redirect($checkout_session->url); // 3- Redirect 
    }

    public function success()
    {
        // Here i Should Change the Order Status To Delivered   ;
        $letId  = request()->orderID;
        $order = Order::find($letId);
        $order->status  = "Delivered";
        $order->save();
        return redirect()->route('orders.index')->with('status', ' SUCCESS');
    }

    public function cancel()
    {
        return redirect()->route('orders.index')->with('error', ' Sometyhing Wrong');
    }

    public function show(string $id)
    {
        $order = Order::find($id);
        if ($order->status == "Confirmed") {
            $order->status = "Delivered";
            $order->save();
            return redirect()->route('orders.index')->with('status', 'Order Delivered!');
        } else if ($order->status == "New") {
            $order->status = "Processing";
            $order->save();
            return view('order.show');
        } else {
            return view('order.show');
        }
    }


    public function edit(string $id)
    {
        $order = Order::find($id);
        $allMedicines  = Medicine::get();
        return view('order.edit', compact(['order',  'allMedicines']));
    }


    public function update(OrderRequest $request, string $id)
    {
        $medArray = $request->medicines;
        $quantArray = $request->quantities;
        $priceArray = $request->prices;
        $typeArray = $request->types;
        $bigArray  = [$medArray, $quantArray, $priceArray, $typeArray];
        $sizeFlag  = false;
        $initialSize = sizeof($medArray);

        foreach ($bigArray as $arr) {
            if (sizeof($arr) != $initialSize) {
                $sizeFlag = true;
            }
        }

        if ($sizeFlag) {
            return redirect()->route('orders.index')->with('error', ' Sometyhing Wrong');
        }

        // else  is Below : 
        $totalPrice = 0;
        for ($i = 0; $i < sizeof($medArray); $i++) {
            $totalPrice = $totalPrice + ($priceArray[$i] * $quantArray[$i]);
        }

        $newOrder =  Order::find($id);
        $newOrder->status  = "WaitingForUserConfirmation";
        $newOrder->user_id =  auth()->user()->id; // creator_id
        $newOrder->customer_id = $request->customer_id;
        $newOrder->delivering_address_id = "1"; // TODO 
        $newOrder->is_insured = true;  // TODO 
        $newOrder->total_price = $totalPrice / 100;
        $newOrder->save();
        $orderID = $newOrder->id;


        for ($i = 0; $i < sizeof($medArray); $i++) {
            if (is_numeric($medArray[$i])) {
                $orderMedicine  =  new OrderMedicine();
                $orderMedicine->order_id = $orderID;
                $orderMedicine->medicine_id =  $medArray[$i];
                $orderMedicine->type =  $typeArray[$i];
                $orderMedicine->quantity =  $quantArray[$i];
                $orderMedicine->price = $priceArray[$i];
                $orderMedicine->save();
            } else {
                $newlyCreatedMedicine  = new Medicine();
                $newlyCreatedMedicine->name  = $medArray[$i];
                $newlyCreatedMedicine->price = $priceArray[$i];
                $newlyCreatedMedicine->save();
                $newMedId  = $newlyCreatedMedicine->id;
                // Save 
                $orderMedicine  =  new OrderMedicine();
                $orderMedicine->order_id = $orderID;
                $orderMedicine->medicine_id =  $newMedId;
                $orderMedicine->type =  $typeArray[$i];
                $orderMedicine->quantity =  $quantArray[$i];
                $orderMedicine->price = $priceArray[$i];
                $orderMedicine->save();
            }
        }

        return redirect()->route('orders.index'); // 3- Redirect 
    }


    public function destroy(string $id)
    {
    }
}
