<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $classes = Classes::orderBy('id', 'desc')->get();
        return view('admin.class_index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.class_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:classes,name',
        ]);

        $class = new Classes();
        $class->name = $request->name;
        $class->status = $request->status;
        $class->save();

        return redirect()->route('class.index')->with('success', 'Class created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $class = Classes::findOrFail($id);
        return view('admin.class_edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required|unique:classes,name,' . $id,
        ]);

        $class = Classes::findOrFail($id);
        $class->name = $request->name;
        $class->status = $request->status;
        $class->save();

        return redirect()->route('class.index')->with('success', 'Class updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->route('class.index')->with('success', 'Class deleted successfully!');
    }
}
