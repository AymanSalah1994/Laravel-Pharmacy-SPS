<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allCustomers = Customer::query();
            if ($request->searchkeyWord) {
                $allCustomers = User::where("userable_type", "App\Models\Customer")
                    ->join('customers', 'users.userable_id', '=', 'customers.id')
                    ->where('name', 'LIKE', "%{$request->searchkeyWord}%")
                    ->get();
            } else {
                $allCustomers = User::where("userable_type", "App\Models\Customer")
                    ->join('customers', 'users.userable_id', '=', 'customers.id')
                    ->get();
            }
            return DataTables::of($allCustomers)
                ->addColumn('action', function ($allCustomers) {
                    $deleteOrRestore = "delete";
                    $showLink  = route('customers.show', $allCustomers->id);
                    $editLink  = route('customers.edit', $allCustomers->id);
                    $deleteLink  = route('customers.destroy', $allCustomers->id);
                    $myField = csrf_field();
                    $myToken = csrf_token();
                    $DEL = $myField . "<input type=\"hidden\" name=\"_method\" value=\"DELETE\"> ";
                    // CSRF_field NOT TOKEN 
                    return
                        "<a href=$showLink class=\"btn btn-primary\" >Show</a>
                        <a href=$editLink class=\"btn btn-warning\" >Edit</a>

                        <a onclick=\"myFunction($allCustomers->id , '$myToken' ) \" class=\"btn btn-danger\">
                        $deleteOrRestore
                        </a>

                        <form id=$allCustomers->id action=$deleteLink method='POST'
                            style=display: hidden class='form-inline'>
                            $DEL
                        </form>";
                })
                ->make(true);
        }
        return view('customers.index');
    }

    public function create()
    {
        // Later Or Cancel , User Register himself 
    }

    public function store(Request $request)
    {
        // Related To Create 
    }

    public function show(Customer $customer)
    {
        $c = Customer::find($customer)->first();
        return view('customers.show', compact('c'));
    }

    public function edit(Customer $customer)
    {
        $cust = Customer::findOrFail($customer->id) ; 
        
        $cust = $cust->with('users')
        ->where('id' , $cust->id)
        ->first() ; 

        
        // dd($cust->users[0]->name) ; 
        return view('customers.edit', compact('cust'));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $allRequestedData = $request->handleRequest();
        $customer = Customer::findOrFail($customer->id);
        $customer->update($allRequestedData);
        return redirect()->route('customers.index')->with('status', 'Customer Updated Successfully');
    }

    public function destroy(Customer $customer)
    {
        $deletedCustomer = Customer::find($customer)->first();
        $userModelOfCustomer = User::where('userable_id', $deletedCustomer->id)
            ->where("userable_type", "App\Models\Customer")
            ->first();
        $userModelOfCustomer->delete();
        $deletedCustomer->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
