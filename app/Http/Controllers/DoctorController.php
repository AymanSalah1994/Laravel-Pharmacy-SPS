<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\DoctorRequest;
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
                    if ($allDoctors->is_banned == 0) {
                        $banORunban = "ban";
                    } else {
                        $banORunban = "unban";
                    }
                    $showLink  = route('doctors.show', $allDoctors->id);
                    $editLink  = route('doctors.edit', $allDoctors->id);
                    $deleteLink  = route('doctors.destroy', $allDoctors->id);
                    $banLink = route('doctors.ban', $allDoctors->id);
                    $myField = csrf_field();
                    $myToken = csrf_token();
                    $DEL = $myField . "<input type=\"hidden\" name=\"_method\" value=\"DELETE\"> ";
                    $BAN = $myField . "<input type=\"hidden\" name=\"_method\" value=\"PUT\"> ";

                    // CSRF_field NOT TOKEN 
                    return
                        "<a href=$showLink class=\"btn btn-primary\" >Show</a>
                        <a href=$editLink class=\"btn btn-warning\" >Edit</a>

                        <a onclick=\"myFunction($allDoctors->id , '$myToken' ) \" class=\"btn btn-danger\">
                        $deleteOrRestore
                        </a>
                        <a  onclick=\"banDoctor( $allDoctors->id  , '$myToken')\" class=\"btn btn-danger\">
                         $banORunban
                        </a>
                        <form id=$allDoctors->id action=$deleteLink method='POST'
                            style=display: hidden class='form-inline'>
                            $DEL
                        </form>
                        <form id='$allDoctors->id' action='$banLink' method='POST'
                        style=display: hidden class='form-inline'>
                        $BAN
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
        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {
        $doctor = new Doctor();
        $doctor->national_id  = $request->input('national_id');
        if ($request->hasFile('avatar_image')) {
            $file = $request->file('avatar_image');
            $doctor->avatar_image = 'ava-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $doctor->avatar_image);
            $doctor->save();
        } else {
            $doctor->avatar_image = "1.jpg"; //Default 
            $doctor->save();
        }

        $userDoctor  = new User();
        $userDoctor->assignRole('doctor');
        $userDoctor->name = $request->input('name');
        $userDoctor->email = $request->input('email');
        $userDoctor->password = Hash::make($request->input('password'));
        $doctor->users()->save($userDoctor);

        return redirect()->route('doctors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $userDoctor = User::where([
            ['userable_id', $id],
            ['userable_type', 'App\Models\Doctor']
        ])->get();
        $userDR = $userDoctor[0];
        return view('doctor.show')->with(compact('doctor', 'userDR'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $userDoctor = User::where([
            ['userable_id', $id],
            ['userable_type', 'App\Models\Doctor']
        ])->get();
        $userDR = $userDoctor[0];
        // dd($userDoctor[0]);
        return view('doctor.edit')->with(compact('doctor', 'userDR'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, string $id)
    {

        $doctor = Doctor::findOrFail($id);
        $userDoctor = User::where([
            ['userable_id', $id],
            ['userable_type', 'App\Models\Doctor']
        ])->get();
        $userDR = $userDoctor[0];
        if ($doctor) {
            $doctor->national_id = $request->national_id;
            // $doctor->avatar_image = $request->avatar_image;
            // $doctor->is_banned = $request->is_banned;
        }
        if ($userDR) {
            $userDR->name = $request->name;
            $userDR->email = $request->email;
            $userDR->password = $request->password;
        }
        $doctor->save();
        $userDR->save();
        return redirect()->route('doctors.index')->with('status', 'DR Updated Successfully');
    }

    public function ban(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        if ($doctor->is_banned == 1) {
            $doctor->is_banned = 0;
            $message = 'Doctor unbanned successfully';
        } else {
            $doctor->is_banned = 1;
            $message = 'Doctor banned successfully';
        }

        $doctor->save();

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $userDoctor = User::where([
            ['userable_id', $id],
            ['userable_type', 'App\Models\Doctor']
        ])->get();
        $userDR = $userDoctor[0];

        $doctor->delete();
        $userDR->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
