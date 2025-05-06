<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the user role and email from the session
        $user_role = session('user_role');
        $userEmail = session('email');

        if ($user_role === 'Admin') {
            // Fetch data for Admin
            $students = Student::all();
            $courses = Course::all();
            $enrollments = Enrollment::all();

            // Load the Admin dashboard view
            return view('dashboard.admin', compact('students', 'courses', 'enrollments'));
        } elseif ($user_role === 'Student') {
            // Fetch data for Student
            $student = Student::where('email', $userEmail)->first();

            // Load the Student dashboard view
            return view('dashboard.student', compact('student'));
        } else {
            // Redirect to login if the role is not recognized
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access.']);
        }
    }
}