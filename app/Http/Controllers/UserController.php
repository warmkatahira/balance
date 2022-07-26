<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {   
        $roles = Role::all();
        $users = User::orderBy('id', 'asc')->get();
        return view('user.index')->with([
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request)
    {
        // roleとstatusを更新 
        for($i = 0; $i < count($request->user_id); $i++) {
            User::where('id', $request->user_id[$i])->update([
                'role_id' => $request->role[$i],
                'status' => $request->status[$i],
            ]);
        }
        return back();
    }
}
