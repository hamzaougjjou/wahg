<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionInCourse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //

    public function index()
    {
        $subscritions = SubscriptionInCourse::all();

        if (!$subscritions) {
            return response()->json([
                'success' => false,
                "message" => "subscritions Not found"
            ], 404);
        }


        foreach ($subscritions as $subscrition) {
            # code...
            $subscrition->coursesofinstrts = $subscrition->coursesofinstrts();
            $subscrition->student = $subscrition->users();
        }

        function getSubscriptions()
        {
            $subscriptions = [
                [
                    'teacher' => 'أحمد',
                    'phone_number' => '01064646464',
                    'teacher_type' => 'عام',
                    'payment_to_teacher' => false,
                    'status' => true,
                    'course' => 'القدرات',
                    'class' => 'كمّي',
                    'price' => 300,
                    'subscription_end_date' => '2024-05-12',
                    'registration_date' => '2024-05-12 10:45',
                ],
                [
                    'teacher' => 'أحمد',
                    'phone_number' => '01064646464',
                    'teacher_type' => 'عام',
                    'payment_to_teacher' => false,
                    'status' => true,
                    'course' => 'القدرات',
                    'class' => 'كمّي',
                    'price' => 300,
                    'subscription_end_date' => '2024-05-12',
                    'registration_date' => '2024-05-12 10:45',
                ],
                [
                    'teacher' => 'أحمد',
                    'phone_number' => '01064646464',
                    'teacher_type' => 'عام',
                    'payment_to_teacher' => false,
                    'status' => true,
                    'course' => 'القدرات',
                    'class' => 'كمّي',
                    'price' => 300,
                    'subscription_end_date' => '2024-05-12',
                    'registration_date' => '2024-05-12 10:45',
                ],
            ];
            return $subscriptions;
        };

        //send data to front end
        return response()->json([
            'success' => true,
            "message" => "subscritions retrieved successfully",
            "subscritions" => getSubscriptions()
        ]);
    }
}
