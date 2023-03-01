<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.register');
    }

    public function store()
    {
        $attribute = request()->validate([
            'name' => ['required', 'max:255', 'min:4'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required']
        ]);
        $attribute['password'] = bcrypt($attribute['password']);
        $attribute['username'] = ucwords($attribute['name']);
        $user = User::create($attribute);

        Auth::login($user);

        session()->flash('success', 'Your account has been created');
        return response('insert success', 200);
    }

    public function createLogin()
    {
        return view('sessions.login');
    }

    public function login()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::attempt($attributes)) {
            return response('success', 200);
        }
        return response('faild', 400);
    }

    public function destroy()
    {
        Auth::logout();
        return response('Goodbye', 200);
    }
}
