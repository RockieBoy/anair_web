<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // index: List users
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    // create: Show create user form
    public function create()
    {
        return view('admin.create');
    }

    // store: Save new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:superadmin,admin,karyawan',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.index')->with('success', 'User berhasil dibuat.');
    }

    // edit: Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    // update: Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|in:superadmin,admin,karyawan',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.index')->with('success', 'User berhasil diperbarui.');
    }

    // destroy: Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Prevent deleting self? Optional but good practice.
        if (auth()->id() == $id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.index')->with('success', 'User berhasil dihapus.');
    }
}
