<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display all users.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    /**
     * Show User Create Form
     */
    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Store New User
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => 1,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
}
