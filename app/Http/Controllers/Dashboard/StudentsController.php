<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search_query = $request->search_query;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($search_query) {

            if ($start_date && $end_date) {
                $students = Student::where("name", "like", "%" . $search_query . "%")->get();
            } else if ($start_date) {
                $students = Student::where("name", "like", "%" . $search_query . "%")->get();
            } else if ($start_date) {
                # code...
                $students = Student::where("name", "like", "%" . $search_query . "%")->get();
            } else {
                $students = Student::where("name", "like", "%" . $search_query . "%")->get();
            }

        } else {
            $students = Student::all();
        }

        $studentsData = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'phone' => $student->phone,
                'used_device' => $student->devices_used,
                'courses' => $student->courses->map(function ($course) {
                    return [
                        'course_id' => $course->id,
                        'price' => $course->price,
                        'from_date' => $course->from_date,
                        'course_name' => $course->course_name,
                        'to_date' => $course->to_date,
                    ];
                })
            ];
        });


        function transformStudentsArray($students)
        {
            $transformedArray = [];
            foreach ($students as $student) {
                foreach ($student['courses'] as $course) {
                    $transformedArray[] = [
                        'id' => $student['id'],
                        'name' => $student['name'],
                        'email' => $student['email'],
                        'phone' => $student['phone'],
                        'used_device' => $student['used_device'],
                        'course_id' => $course['course_id'],
                        'price' => $course['price'],
                        'from_date' => $course['from_date'],
                        'course_name' => $course['course_name'],
                        'to_date' => $course['to_date'],
                    ];
                }
            }
            return $transformedArray;
        }
        return response()->json([
            'success' => true,
            "message" => "students retrieved successfully",
            "studends" => transformStudentsArray($studentsData)
        ]);

    }

    public function show(string $id)
    {
        $student = Student::find( $id );

        //check if student with this id not exists
        if ( !$student ) {
            return response()->json([
                'success' => false,
                "message" => "student Not found"
            ] , 404 );
        }
        //get user courses by hasMany relation (check Student model)
        $student->courses;
        //send data to front end
        return response()->json([
            'success' => true,
            "message" => "student retrieved successfully",
            "studend" => $student
        ]);
    }


}
