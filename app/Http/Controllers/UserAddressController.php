<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class UserAddressController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allAddresses = UserAddress::query();
            if ($request->searchkeyWord) {
                $allAddresses = $allAddresses->where('name', 'LIKE', "%{$request->searchkeyWord}%");
                // TODO 
                // name >> Street Name 
            }
            $allAddresses = $allAddresses->get();
            return DataTables::of($allAddresses)
                ->addColumn('action', function ($allAddresses) {
                    $showLink  = route('useraddresses.show', $allAddresses->id);
                    $editLink  = route('useraddresses.edit', $allAddresses->id);
                    $deleteLink  = route('useraddresses.destroy', $allAddresses->id);
                    $myField = csrf_field();
                    $myToken = csrf_token();
                    $DEL = $myField . "<input type=\"hidden\" name=\"_method\" value=\"DELETE\"> ";
                    // CSRF_field NOT TOKEN 
                    return
                        "<a href=$showLink class=\"btn btn-primary\" >Show</a>
                        <a href=$editLink class=\"btn btn-warning\" >Edit</a>
                        <a onclick=\"myFunction($allAddresses->id , '$myToken' ) \" class=\"btn btn-danger\">
                        Delete
                        </a>
                        <form id=$allAddresses->id action=$deleteLink method='POST'
                            style=display: hidden class='form-inline'>
                            $DEL
                        </form>";
                })
                ->make(true);
        }
        return view('user-addresses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No Creation , A User Creates It Himself 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Related To Create 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Later TODO 
        // TODO
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $med = Medicine::findOrFail($medicine->id);
        return view('medicine.edit', compact('med'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $allRequestedData = $request->handleRequest();
        // $medicine = Medicine::findOrFail($medicine->id);
        // $medicine->update($allRequestedData);
        return redirect()->route('medicines.index')->with('status', 'Medicine Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $deletedMedicine = Medicine::find($medicine)->first();
        // $deletedMedicine->delete();
        // return response()->json([
            // 'success' => 'Record deleted successfully!'
        // ]);
    }
}
