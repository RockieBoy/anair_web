<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        return view('login', ['title' => 'Login']);
    }

    
    public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required','string'],
        'password' => ['required']
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        $user = Auth::user();
        if ($user->role === 'superadmin') {
            return redirect()->route('admin.index');
        }

        return redirect()->intended('welcome');
    }

    return back()->with('loginError', 'Login Failed');
}

    public function logout(Request $request){
        Auth::logout();
        request()->session()->invalidate();
        return redirect('/login');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
