<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua data pengguna
        $users = User::all();

        // Kembalikan ke view
        return view('admin.data-pengguna', compact('users'));
    }

    // UserController.php
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User  deleted successfully.']);
    }
}
