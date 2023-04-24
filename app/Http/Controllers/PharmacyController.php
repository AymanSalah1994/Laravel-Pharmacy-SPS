<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allPharmacies = Pharmacy::query();
            // $allPharmacies = User::where("userable_type", "App\Models\Pharmacy")
            //     ->join('pharmacies', 'users.userable_id', '=', 'pharmacies.id')
            //     ->where('name', 'LIKE', "%{$request->searchkeyWord}%")
            //     ->get();

            // Applying Our Own Search In BackEnd 
            if ($request->searchkeyWord) {
                $allPharmacies = User::where("userable_type", "App\Models\Pharmacy")
                    ->join('pharmacies', 'users.userable_id', '=', 'pharmacies.id')
                    ->where('name', 'LIKE', "%{$request->searchkeyWord}%")
                     ->whereNull('deleted_at')    
                    // ->orderBy('page_order')
                    ->get();
            } else {
                $allPharmacies = User::where("userable_type", "App\Models\Pharmacy")
                    ->join('pharmacies', 'users.userable_id', '=', 'pharmacies.id')
                     ->whereNull('deleted_at')
                    ->get();
            }
            return DataTables::of($allPharmacies)
                ->addColumn('action', function ($allPharmacies) {
                    $deleteOrRestore = "delete";
                    if ($allPharmacies->deleted_at) {
                        $deleteOrRestore = "Restore";
                    }
                    $showLink  = route('pharmacies.show', $allPharmacies->id);
                    $editLink  = route('pharmacies.edit', $allPharmacies->id);
                    $deleteLink  = route('pharmacies.destroy', $allPharmacies->id);
                    $myField = csrf_field();
                    $myToken = csrf_token();
                    $DEL = $myField . "<input type=\"hidden\" name=\"_method\" value=\"DELETE\"> ";
                    // CSRF_field NOT TOKEN 
                    return
                        "<a href=$showLink class=\"btn btn-primary\" >Show</a>
                        <a href=$editLink class=\"btn btn-warning\" >Edit</a>

                        <a onclick=\"myFunction($allPharmacies->id , '$myToken' ) \" class=\"btn btn-danger\">
                        $deleteOrRestore
                        </a>

                        <form id=$allPharmacies->id action=$deleteLink method='POST'
                            style=display: hidden class='form-inline'>
                            $DEL
                        </form>";
                })
                ->make(true);
        }
        return view('pharmacy.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pharmacy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pharmacy = new Pharmacy();
        $pharmacy->national_id  = $request->input('national_id');
        $pharmacy->area_id  = $request->input('area_id');
        $pharmacy->priority  = $request->input('priority');
        if ($request->hasFile('avatar_image')) {
            $file = $request->file('avatar_image');
            $pharmacy->avatar_image = 'ava-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $pharmacy->avatar_image);
            $pharmacy->save();
            // TODO: Something Wrong with Files (Ubuntu Windows ?)
        } else {
            $pharmacy->avatar_image = "1.jpg"; //Default 
            $pharmacy->save();
        }

        $userPharmacy  = new User();
        $userPharmacy->assignRole('pharmacy');
        $userPharmacy->name = $request->input('name');
        $userPharmacy->email = $request->input('email');
        $userPharmacy->password = Hash::make($request->input('password'));
        $pharmacy->users()->save($userPharmacy);

        return redirect()->route('pharmacies.index');
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
    public function destroy(Pharmacy $pharmacy)
    {
        $deletedPharmacy = Pharmacy::find($pharmacy)->first();
        $deletedPharmacy->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);

        // TODO , Delete ALSO From User Table Model 
    }

    public function restoreAll()
    {
        Pharmacy::onlyTrashed()->restore();
        return redirect()->route('pharmacies.index');
    }
}



/**
 *  OLD DESTROY IF NEEDED FOR ANYTHINNG
 */
// public function destroy(Pharmacy $pharmacy)
//     {
//         // TODO >> Soft Delete , and Check Assigned pharmacys 
//         $deletedPharmacy = Pharmacy::find($pharmacy)->first();
//         $deletedPharmacy->delete();
//         // TODO , Delete ALSO From User Table Model 
// TODO delete Image TOO 
//         return response()->json([
//             'success' => 'Record deleted successfully!'
//         ]);
//     }