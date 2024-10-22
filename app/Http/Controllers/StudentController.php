<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();

        return response()->json($students);
    }

    public function create() {
        return view('student.create');
    }

    public function store(Request $request) {

//        validate the request

        $validated = $request->validate([
            'roll_no' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'phone' => 'required',
        ]);

        $student = new Student();

        $student->roll_no = $request->input('roll_no');
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');

        $student->save();

        return response()->json($student);
    }

    public function show($id) {
        $student = Student::find($id);

        return response()->json($student);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'roll_no' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'phone' => 'required',
        ]);

        $student = Student::find($id);

        $student->roll_no = $request->input('roll_no');
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');
        $student->save();

        return response()->json($student);
    }

    public function destroy($id) {
        $student = Student::find($id);

        $student->delete();

        return response()->json($student);
    }
}
