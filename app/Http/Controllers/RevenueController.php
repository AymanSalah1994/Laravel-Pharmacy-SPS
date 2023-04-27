<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {



        $allRevenues2 = Order::query()
            ->join('users', 'users.userable_id', '=', 'orders.pharmacy_id')
            ->where("users.userable_type", "App\Models\Pharmacy")
            ->select('users.name as PharmacyName')
            ->selectRaw('count(orders.id) as totalOrders')
            ->selectRaw('sum(orders.total_price) as totalPrices')
            ->groupby('users.name')
            ->get();




        // dd($allRevenues2);


        return view('revenue.index' , compact('allRevenues2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
