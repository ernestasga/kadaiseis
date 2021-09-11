<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    public function updateRole(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'role' => 'required|integer'
        ]);
        $user = User::findOrFail($validated['id']);
        $res = $user->update([
            'role' => $validated['role']
        ]);

        if($res){
            return response()->json([
                'success' => 'User role updated successfully',
            ]);
        }
        return response()->json([
            'error' => 'Failed to update user role'
        ]);
    }
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);
        $user = User::findOrFail($validated['id']);
        $res = $user->delete();

        if($res){
            return response()->json([
                'success' => 'User deleted successfully',
            ]);
        }
        return response()->json([
            'error' => 'Failed to delete user'
        ]);

    }
}
