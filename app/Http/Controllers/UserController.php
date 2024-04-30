<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import facade
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

    public function update(Request $request, User $user)
    {
        // Authorization
        if (Auth::id() !== $user->id) { // Check if current user is editing themselves
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // ... your validation ... 

        $user->update($request->only(['name', 'email']));

        return response()->json($user); // Return updated user data
    }

    public function destroy(User $user)
    {
        // Authorization (Ensure the current user is an admin)
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $user->delete();
        return redirect()->route('user.manage')->with('success', 'User deleted successfully.');
    }
}

