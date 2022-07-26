<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {   
        $users = User::orderBy('id', 'asc')->get();
        return view('user.index')->with([
            'users' => $users,
        ]);
    }

    public function update(Request $request)
    {
        // statusを更新 
        for($i = 0; $i < count($request->user_id); $i++) {
            User::where('id', $request->user_id[$i])->update(['status' => $request->status[$i]]);
        }
        return back();
    }
}
