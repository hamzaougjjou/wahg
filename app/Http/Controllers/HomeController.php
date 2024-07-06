<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CoursesOfInstructor;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_courses_level()
    {
        $courses = CoursesOfInstructor::all()->groupBy("educational_level")->toArray();
        $levels = [];
        foreach ($courses as $key => $value) {
            array_push( $levels , $key);
        }
        return response()->json([
            'message' => 'Success',
            'levels' => $levels,
        ], 200);
    }

    public function courses_by_level(string $level)
    {
        $courses = CoursesOfInstructor::where("educational_level" ,'=', $level)->get();
        return response()->json([
            'message' => 'Success',
            'courses' => $courses,
        ], 200);
    }


}
