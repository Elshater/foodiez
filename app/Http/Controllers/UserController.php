<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    //Index Method
    public function Index(){
        return view('frontend.master');
    }
}
