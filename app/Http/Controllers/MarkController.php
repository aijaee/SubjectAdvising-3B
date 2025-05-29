<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\Enrollment;

class MarkController extends Controller
{
    public function index()
    {
        $marks = Mark::with('enrollment')->paginate(10);
        return view('marks.index', compact('marks'));
    }

    public function create()
    {
        $enrollments = Enrollment::all();
        return view('marks.create', compact('enrollments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,enrollment_id',
            'mark' => 'nullable|numeric|min:0|max:100',
            'status' => 'nullable|in:Pass,Fail',
            'remark' => 'nullable|string',
            'mark_date' => 'nullable|date',
        ]);

        Mark::create($validated);

        return redirect()->route('marks.index')->with('success', 'Mark added successfully.');
    }

    public function show($id)
    {
        $mark = Mark::with('enrollment')->findOrFail($id);
        return view('marks.show', compact('mark'));
    }

    public function edit($id)
    {
        $mark = Mark::findOrFail($id);
        $enrollments = Enrollment::all();
        return view('marks.edit', compact('mark', 'enrollments'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,enrollment_id',
            'mark' => 'nullable|numeric|min:0|max:100',
            'status' => 'nullable|in:Pass,Fail',
            'remark' => 'nullable|string',
            'mark_date' => 'nullable|date',
        ]);

        $mark = Mark::findOrFail($id);
        $mark->update($validated);

        return redirect()->route('marks.index')->with('success', 'Mark updated successfully.');
    }

    public function destroy($id)
    {
        $mark = Mark::findOrFail($id);
        $mark->delete();

        return redirect()->route('marks.index')->with('success', 'Mark deleted successfully.');
    }
}
