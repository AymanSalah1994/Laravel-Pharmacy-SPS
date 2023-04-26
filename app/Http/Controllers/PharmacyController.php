<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\Area;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\StorePharmacyRequest;
use App\Http\Requests\UpdatePharmacyRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


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

    public function create()
    {
        return view('pharmacy.create');
    }


    public function store(StorePharmacyRequest $request)
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


    public function show(string $id)
    {
        // dd($id);
        // if($id == "profile")
        // {
        //     $id = auth()->user()->userable_id;
        // }
        // dd($id);
        $pharmacy = Pharmacy::find($id)->first();
        $userPharma = User::where(
            [
                ['userable_id', $id],
                ['userable_type', 'App\Models\Pharmacy']
            ]

        )->get();
        $userPharmacy =  $userPharma[0];

        return view('pharmacy.show', compact('pharmacy', 'userPharmacy'));
    }
    public function showProfile(string $id)
    {
        dd($id);

        $userPharma = User::where(
            [
                ['userable_id', $id],
                ['userable_type', 'App\Models\Pharmacy']
            ]

        )->get();
        $userPharmacy =  $userPharma[0];

        return view('pharmacy.show', compact('userPharmacy'));
    }


    public function edit(string $id)
    {
        $pharmacy = Pharmacy::find($id);
        $areas = Area::all();
        $userPharmacy = User::where(
            [
                ['userable_id', $id],
                ['userable_type', 'App\Models\Pharmacy']
            ]

        )->get();

        $userPharma =  $userPharmacy[0];
        // dd($userPharma);
        return view('pharmacy.edit', compact('pharmacy', 'userPharma', 'areas'));
    }

    public function update(UpdatePharmacyRequest $request)
    {


        $pharmacy = Pharmacy::find($request->id);
        $pharmacy->national_id  = $request->input('national_id');
        if (Auth::user()->hasRole('admin')) {
            $pharmacy->area_id  = $request->input('area_id');
            $pharmacy->priority  = $request->input('priority');
        }

        if ($request->hasFile('avatar_image')) {
            if ($pharmacy->avatar_image) {
                Storage::delete($pharmacy->avatar_image);
            }
            $file = $request->file('avatar_image');
            $pharmacy->avatar_image = 'ava-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $pharmacy->avatar_image);
        }


        $userPharmacy = User::where([
            ['userable_id', $request->id],
            ['userable_type', 'App\Models\Pharmacy']
        ])->first();

        $userPharmacy->name = $request->input('name');
        $userPharmacy->email = $request->input('email');
        $userPharmacy->password = Hash::make($request->input('password'));
        $request->merge([
            'userPharmacy' => $userPharmacy->userable_id,
        ]);
        $pharmacy->save();
        $pharmacy->users()->save($userPharmacy);


        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('pharmacies.index')->with('status', 'Pharmacy Updated Successfully');
        } else {
            return redirect()->route('pharmacies.show', $request->id)->with('status', 'Pharmacy Updated Successfully');
        }
    }

    public function destroy(string $id)
    {

        $deletedPharmacy = Pharmacy::find($id)->first();
        $userPharma = User::where([
            ['userable_id', $id],
            ['userable_type', 'App\Models\Pharmacy']
        ])->get();
        $userPharmacy = $userPharma[0];

        $deletedPharmacy->delete();
        $userPharmacy->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function restoreAll()
    {
        Pharmacy::onlyTrashed()->restore();
        return redirect()->route('pharmacies.index');
    }
}

