<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginCheckController extends Controller
{
    public function index()
    {
        return view('login_check_ng');
    }
}