<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $examinations = Examination::orderBy('id', 'desc')->get();
        return view('admin.examination_index', compact('examinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.examination_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:midterm,final',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ]);

        $examination = new Examination();
        $examination->name = $request->name;
        $examination->type = $request->type;
        $examination->description = $request->description;
        $examination->status = $request->status;

        $examination->save();

        return redirect()->route('examination.index')->with('success', 'Examination created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $examination = Examination::findOrFail($id);
        return view('admin.examination_edit', compact('examination'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:midterm,final',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ]);
        $examination = Examination::findOrFail($request->id);
        $examination->name = $request->name;
        $examination->type = $request->type;
        $examination->description = $request->description;
        $examination->status = $request->status;

        $examination->update();

        return redirect()->route('examination.index')->with('success', 'Examination updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $examination = Examination::findOrFail($id);
        $examination->delete();

        return redirect()->route('examination.index')->with('success', 'Examination deleted successfully');
    }
}
