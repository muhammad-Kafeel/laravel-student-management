<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of all users (Admin Panel)
     */
    public function index()
    {
        // Get all users from database
        $users = User::all();
        
        // Pass users to the view
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the user's role
     */
    public function update(Request $request, string $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        
        // Validate the incoming request
        $request->validate([
            'role' => 'required|in:admin,teacher,student'
        ]);
        
        // Update the user's role
        $user->role = $request->role;
        $user->save();
        
        // Redirect back with success message
        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
