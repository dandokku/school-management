<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index() {
        return response()->json(Student::all());
    }

    public function store(Request $request, Student $student) {
        $data = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone'=> 'required|string|max:15',
            'address'=> 'required|string|max:255',
            'course_of_study'=> 'required|string|max:255',
            'profile_picture'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($request->hasFile('profile_picture')){
            $data['profile_picture']= $request->file('profile_picture')->store('assets', 'public');
        }

        // if($request->hasFile('profile_picture')){
        //     $file = $request->file('profile_picture');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('students'), $filename);
        //     $request=>merge
        // }

        $student = Student::create($data);
        return response()->json($student, 201);
    }

    public function show($id) {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, Student $student) {
         $data = $request->validate([
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:students,email'.$student->id,
            'phone'=> 'sometimes|required|string|max:15',
            'address'=> 'sometimes|required|string|max:255',
            'course_of_study'=> 'sometimes|required|string|max:255',
            'profile_picture'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($request->hasFile('profile_picture')){
            if($student->profile_picture){
                Storage::disk('public')->delete($student->profile_picture);
            }
            $data['profile_picture']= $request->file('profile_picture')->store('assets', 'public');
        }

        $student->update($data);
        return response()->json($student, 201);
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
