<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use FactoryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where("user_type", "teacher")->get();
        foreach ($teachers as $teacher) {
            $teacher -> teacher;
        }

        //check if teachers with this id not exists
        if (!$teachers) {
            return response()->json([
                'success' => false,
                "message" => "teachers Not found"
            ], 404);
        }

        //send data to front end
        return response()->json([
            'success' => true,
            "message" => "teachers retrieved successfully",
            "teachers" => $teachers
        ]);

    }

    public function store(Request $request)
    {
        //chech if data s valid 
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users"],
            "description" => ["required", "string"],
            "birth_date" => ["required", "date"],
            "phone" => ["required", "numeric"],
            "password" => ["required", "string"],
            "type" => ["required", "string"], //public or private
            "allowed_number" => ["required", "integer"],
            "video_url" => ["url"],
            "image" => ["required", "required", "mimes:jpg,png,jpg,JPG,png,PNG,jpeg,JPEG", 'max:2048']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                "message" => "invalid data sent",
                "errors" => $validator->errors()
            ], 404);
        }

        //inser data in user table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phonenumber' => $request->phone,
            'date_of_birth' => $request->birth_date,
            'gender' => null,
            'password' => Hash::make($request->password),
            'password_confirmation' => Hash::make($request->password),
            'is_admin' => false,
            'user_type' => "teacher",
        ]);

        if (!$user) {
            //teacher is created
            return response()->json([
                'success' => false,
                "message" => "teacher not created.",
            ], 500);
        }

        try {
            $file = $request->file('image');
            $path = $file->store('uploads', 'storage');
        } catch (\Exception $exception) {
            $path = null;
        }

        $teacher = Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $path,
            'user_id' => $user->id,
            'description' => $request->description,
            'video_url' => $request->video_url,
            'type' => $request->type,
            'allowed_number' => $request->allowed_number
        ]);

        if (!$teacher) {
            User::find($user->id)->first()->delete();
            //teacher is created
            return response()->json([
                'success' => false,
                "message" => "teacher not created.",
            ], 500);
        }

        $teacher->user;
        $teacher->image_url = $path ? url('/') . "/" . $path : null;

        //teacher is created
        return response()->json([
            'success' => false,
            "message" => "teacher created suucessfully",
            "data" => $teacher
        ]);
    }
}
