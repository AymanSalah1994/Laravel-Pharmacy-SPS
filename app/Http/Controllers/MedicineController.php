<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineRequest;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allMedicines = Medicine::query();
            if ($request->searchkeyWord) {
                $allMedicines = $allMedicines->where('name', 'LIKE', "%Prof%");
                // {$request->searchkeyWord}
            }
            $allMedicines = $allMedicines->get();
            return DataTables::of($allMedicines)
                ->addColumn('action', function ($allMedicines) {
                    $showLink  = route('medicines.show', $allMedicines->id);
                    $editLink  = route('medicines.edit', $allMedicines->id);
                    $deleteLink  = route('medicines.destroy', $allMedicines->id);
                    $myField = csrf_field();
                    $myToken = csrf_token();
                    $DEL = $myField . "<input type=\"hidden\" name=\"_method\" value=\"DELETE\"> ";
                    // CSRF_field NOT TOKEN
                    return
                        "<a href=$showLink class=\"btn btn-primary\" >Show</a>
                        <a href=$editLink class=\"btn btn-warning\" >Edit</a>
                        <a onclick=\"myFunction($allMedicines->id , '$myToken' ) \" class=\"btn btn-danger\">
                        Delete
                        </a>
                        <form id=$allMedicines->id action=$deleteLink method='POST'
                            style=display: hidden class='form-inline'>
                            $DEL
                        </form>";
                })
                ->make(true);
        }
        return view('medicine.index');
    } //End of Index

    public function create()
    {
        return view('medicine.create');
    }

    public function store(MedicineRequest $request)
    {
        $allRequestData = $request->handleRequest();
        Medicine::create($allRequestData);
        return redirect()->route("medicines.index")->with('status', 'Medicine Created Successfully');
    }

    public function show(string $id)
    {
        $medicine = Medicine::where('id',$id)->first();
        return view('medicine.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        $med = Medicine::findOrFail($medicine->id);
        return view('medicine.edit', compact('med'));
    }

    public function update(MedicineRequest $request, Medicine $medicine)
    {
        $allRequestedData = $request->handleRequest();
        $medicine = Medicine::findOrFail($medicine->id);
        $medicine->update($allRequestedData);
        return redirect()->route('medicines.index')->with('status', 'Medicine Updated Successfully');
    }

    public function destroy(Medicine $medicine)
    {
        $deletedMedicine = Medicine::find($medicine)->first();
        $deletedMedicine->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
