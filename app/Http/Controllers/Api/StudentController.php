<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index() {
        return response()->json(Student::all());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students',
        ]);

        $student = Student::create($validated);
        return response()->json($student, 201);
    }

    public function show($id) {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id) {
        $student = Student::findOrFail($id);
        $student->update($request->only('first_name', 'last_name', 'email'));
        return response()->json($student);
    }

    public function destroy($id) {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Student deleted']);
    }

    public function assignCourse(Request $request, $id) {
        $request->validate([
            'course_ids' => 'required|array',
        ]);

        $student = Student::findOrFail($id);
        $student->courses()->syncWithoutDetaching($request->course_ids);

        return response()->json(['message' => 'Courses assigned']);
    }

    public function getCourses($id) {
        $student = Student::with('courses')->findOrFail($id);
        return response()->json($student->courses);
    }
}
