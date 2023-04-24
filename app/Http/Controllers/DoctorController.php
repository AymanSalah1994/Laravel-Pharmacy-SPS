<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); //  USER Model
        // dd($user);
        $userType = $user->userable_type;
        $userFarmacist  = false;
        if ($userType == "App\Models\Pharmacy") {
            $userFarmacist = Pharmacy::find($user->userable_id)->first();  // Pharmacy Model instance 
        }

        if ($request->ajax()) {
            $allDoctors = Doctor::query();
            // Applying Our Own Search In BackEnd 
            if ($request->searchkeyWord) {
                $allDoctors = User::where("userable_type", "App\Models\Doctor")
                    ->join('doctors', 'users.userable_id', '=', 'doctors.id')
                    ->where('name', 'LIKE', "%{$request->searchkeyWord}%")
                    ->get();
            } else {
                $allDoctors = User::where("userable_type", "App\Models\Doctor")
                    ->join('doctors', 'users.userable_id', '=', 'doctors.id')
                    ->get();
            }

            if ($userFarmacist) {

                $allDoctors = $allDoctors->where('doctors.pharmacy_id', $userFarmacist->id);
            }

            return DataTables::of($allDoctors)
                ->addColumn('action', function ($allDoctors) {
                    $deleteOrRestore = "delete";
                    if ($allDoctors->deleted_at) {
                        $deleteOrRestore = "Restore";
                    }
                    $showLink  = route('pharmacies.show', $allDoctors->id);
                    $editLink  = route('pharmacies.edit', $allDoctors->id);
                    $deleteLink  = route('pharmacies.destroy', $allDoctors->id);
                    $myField = csrf_field();
                    $myToken = csrf_token();
                    $DEL = $myField . "<input type=\"hidden\" name=\"_method\" value=\"DELETE\"> ";
                    // CSRF_field NOT TOKEN 
                    return
                        "<a href=$showLink class=\"btn btn-primary\" >Show</a>
                        <a href=$editLink class=\"btn btn-warning\" >Edit</a>

                        <a onclick=\"myFunction($allDoctors->id , '$myToken' ) \" class=\"btn btn-danger\">
                        $deleteOrRestore
                        </a>

                        <form id=$allDoctors->id action=$deleteLink method='POST'
                            style=display: hidden class='form-inline'>
                            $DEL
                        </form>";
                })
                ->make(true);
        }
        return view('doctor.index');
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
