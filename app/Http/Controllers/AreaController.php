<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allAreas = Area::query();
            if ($request->searchkeyWord) {
                $allAreas = $allAreas->where('name', 'LIKE', "%Prof%");
                // {$request->searchkeyWord}
            }
            $allAreas = $allAreas->get();
            return DataTables::of($allAreas)
                ->addColumn('action', function ($allAreas) {
                    $showLink  = route('areas.show', $allAreas->id);
                    $editLink  = route('areas.edit', $allAreas->id);
                    $deleteLink  = route('areas.destroy', $allAreas->id);
                    $myField = csrf_field();
                    $myToken = csrf_token();
                    $DEL = $myField . "<input type=\"hidden\" name=\"_method\" value=\"DELETE\"> ";
                    // CSRF_field NOT TOKEN
                    return
                        "<a href=$showLink class=\"btn btn-primary\" >Show</a>
                        <a href=$editLink class=\"btn btn-warning\" >Edit</a>
                        <a onclick=\"myFunction($allAreas->id , '$myToken' ) \" class=\"btn btn-danger\">
                        Delete
                        </a>
                        <form id=$allAreas->id action=$deleteLink method='POST'
                            style=display: hidden class='form-inline'>
                            $DEL
                        </form>";
                })
                ->make(true);
        }
        return view('areas.index');
    } //End of Index

    public function create()
    {
        $countries = DB::table('countries')->get();
        return view('areas.create', compact('countries'));
    }

    public function store(AreaRequest $request)
    {
        $allRequestData = $request->handleRequest();
        Area::create($allRequestData);
        return redirect()->route("areas.index")->with('status', 'Area Created Successfully');
    }

    public function show(string $id)
    {
        // TODO
        // @dd($id);
        $area = new Area();
        $area = Area::find($id);
        $areas = Area::where('country_id', $area->country_id)->get();
        return view('areas.show', compact('area','areas'));
    }

    public function edit(Area $area)
    {
        $countries = DB::table('countries')->get();
        $ar = Area::findOrFail($area->id);
        return view('areas.edit', compact(['ar', 'countries']));
    }

    public function update(AreaRequest $request, Area $area)
    {
        $allRequestedData = $request->handleRequest();
        $area = Area::findOrFail($area->id);
        $area->update($allRequestedData);
        return redirect()->route('areas.index')->with('status', 'Area Updated Successfully');
    }

    public function destroy(Area $area)
    {
        $deletedArea = Area::find($area)->first();
        $deletedArea->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
