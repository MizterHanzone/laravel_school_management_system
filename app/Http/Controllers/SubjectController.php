<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subjects = Subject::Orderby('id', 'desc')->get();
        return view('admin.subject_index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.subject_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:subjects,name',
        ]);

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->status = $request->status;
        $subject->save();

        return redirect()->route('subject.index')->with('success', 'Subject created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $subject = Subject::findOrFail($id);
        return view('admin.subject_edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required|unique:subjects,name,' . $id,
        ]);

        $subject = Subject::findOrFail($id);
        $subject->name = $request->name;
        $subject->status = $request->status;
        $subject->save();

        return redirect()->route('subject.index')->with('success', 'Subject updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subject.index')->with('success', 'Subject deleted successfully!');
    }
}
