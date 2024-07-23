<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $d['title'] = 'User List';
        $d['model'] = User::paginate(10);
        return view('users.userList',$d);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $d['title']='User Form';
        $d['model']=new User();
        return view('users.createUser', $d);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // confirmed checks for password_confirmation field
        ]);

        // Hash the password
        $validatedData['password'] = Hash::make($request->password);

        // Create the user
        $user = User::create($validatedData);

        // Redirect to a success page or route
        return redirect()->route('user-list')->with('success', 'User registered successfully.');
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
        $d['title']='User Form';
        $d['model']=User::find($id);
        return view('users.editUser',$d);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Ignore current user's email for uniqueness
            'password' => 'nullable|string|min:8|confirmed', // Use 'nullable' to allow optional password update
        ]);

        // Find the user to update
        $user = User::findOrFail($id);

        // Update user attributes
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the updated user
        $user->save();

        // Redirect to a success page or route
        return redirect()->route('user-list')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        // dd($id);
        // Check if the authenticated user can delete this resident
        if ($request->session()->get('user_id') == $id) {
            return redirect()->route('user-list')->with('error', 'You are not authorized to delete your own data.');
        }

        $data=User::destroy($id);
        return redirect()->route('user-list')->with('success', 'User deleted successfully.');
    }
}
