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
        $user_role = session('user_role');
        $userEmail = session('email');

        if ($user_role === 'Admin') {
            $students = Student::all();
            $courses = Course::all();
            $enrollments = Enrollment::all();

            return view('dashboard.admin', compact('students', 'courses', 'enrollments'));
        } elseif ($user_role === 'Student') {
            $student = Student::where('email', $userEmail)->first();

            return view('dashboard.student', compact('student'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access.']);
        }
    }
}