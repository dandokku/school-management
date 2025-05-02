<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index() {
        return response()->json(Course::all());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $course = Course::create($validated);
        return response()->json($course, 201);
    }
}

