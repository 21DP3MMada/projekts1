<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('userManage', compact('users'));
    }

    public function updateUserType(Request $request, User $user)
    {
        $request->validate([
            'usertype' => 'required|in:user,admin',
        ]);

        $user->usertype = $request->usertype;
        $user->save();

        return redirect()->route('user.manage')->with('success', 'User type updated successfully.');
    }
}

