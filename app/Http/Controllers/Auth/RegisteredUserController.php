<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Validator;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'birthdate' => ['required', 'before:today'],
            'gender' => ['required'],
            'usertype' => ['required', 'in:user,admin'], // Only user or admin
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'usertype' => $request->usertype,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
        ]);

        event(new Registered($user));

        Auth::login($user);
        $redirectUrl = $user->usertype == 'admin' ? route('admin.dashboard') : route('dashboard', parameters: $request->email);

        return response()->json(['redirect_url' => $redirectUrl]);
    }
}
