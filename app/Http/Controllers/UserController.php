<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Base;

class UserController extends Controller
{
    public function index()
    {   
        $roles = Role::all();
        $users = User::orderBy('id', 'asc')->get();
        $bases = Base::all();
        return view('user.index')->with([
            'users' => $users,
            'roles' => $roles,
            'bases' => $bases,
        ]);
    }

    public function update(Request $request)
    {
        // roleとstatusを更新 
        for($i = 0; $i < count($request->user_id); $i++) {
            User::where('id', $request->user_id[$i])->update([
                'base_id' => $request->base[$i],
                'name' => $request->name[$i],
                'role_id' => $request->role[$i],
                'status' => $request->status[$i],
            ]);
        }
        return back();
    }
}
