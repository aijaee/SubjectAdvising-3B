<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Fetch search and filter inputs
        $query = $request->input('query', '');
        $gender = $request->input('gender', '');

        // Fetch students based on search and filter
        $students = Student::when($query, function ($q) use ($query) {
            $q->where('full_name', 'like', '%' . $query . '%');
        })
        ->when($gender, function ($q) use ($gender) {
            $q->where('gender', $gender);
        })
        ->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            '_section' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:students,email',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('picture')) {
            $filePath = $request->file('picture')->store('students', 'public');
            $validatedData['picture'] = $filePath;
        }

        // Save the student to the database
        Student::create($validatedData);

        // Redirect with success message
        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            '_section' => 'required|string|max:10',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:student,email,' . $student->id,
            'picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $filePath = $request->file('picture')->store('students', 'public');
            $validated['picture'] = $filePath;
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->picture) {
            Storage::disk('public')->delete($student->picture);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
