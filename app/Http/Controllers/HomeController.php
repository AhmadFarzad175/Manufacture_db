<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {

        $data = [

            "id" => 1,
            "title" => "farzad",
            'description" => "sohrab'

        ];

        return response()->json(
            array(

                'data' => $data,
            )
        );
    }
}
