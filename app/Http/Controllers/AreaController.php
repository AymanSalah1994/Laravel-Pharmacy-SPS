<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    
    public function index(Request $request)
    {
        return view('medicine.index');
    } //End of Index 

    public function create()
    {
        return view('medicine.create');
    }

    public function store(MedicineRequest $request)
    {
        // $allRequestData = $request->handleRequest();
        // Medicine::create($allRequestData);
        // return redirect()->route("medicines.index")->with('status', 'Medicine Created Successfully');
    }

    public function show(Area $medicine)
    {
        // $m = Medicine::find($medicine)->first();
        return view('medicine.show', compact('m'));
    }

    public function edit(Area $medicine)
    {
        // $med = Medicine::findOrFail($medicine->id);
        return view('medicine.edit', compact('med'));
    }

    public function update(MedicineRequest $request, Area $medicine)
    {
        // $allRequestedData = $request->handleRequest();
        // $medicine = Medicine::findOrFail($medicine->id);
        // $medicine->update($allRequestedData);
        return redirect()->route('medicines.index')->with('status', 'Medicine Updated Successfully');

    }

    public function destroy(Area $medicine)
    {
        // $deletedMedicine = Medicine::find($medicine)->first();
        // $deletedMedicine->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
