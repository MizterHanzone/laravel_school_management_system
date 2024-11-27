<?php

namespace App\Http\Controllers;

use App\Models\AcademiYear;
use Illuminate\Http\Request;

class AcademiYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $academiYears = AcademiYear::orderBy('id', 'desc')->get();
        return view('admin.academicyear_index', compact('academiYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.academicyear_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:academi_years,name',
        ]);

        $academiYear = new AcademiYear();
        $academiYear->name = $request->name;
        $academiYear->save();

        return redirect()->route('academic_year.index')->with('success', 'Academic year created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $academiYear = AcademiYear::findOrFail($id);
        return view('admin.academicyear_edit', compact('academiYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required|unique:academi_years,name,' .$id,
        ]);

        $academiYear = AcademiYear::findOrFail($id);
        $academiYear->name = $request->name;
        $academiYear->save();

        return redirect()->route('academic_year.index')->with('success', 'Academic year updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $academiYear = AcademiYear::findOrFail($id);
        $academiYear->delete();
        return redirect()->route('academic_year.index')->with('success', 'Academic year deleted successfully!');
    }
}
