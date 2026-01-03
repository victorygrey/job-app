<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['sometimes', 'exists:roles,id'],
        ]);

        $roleId = $request->role_id ?? \App\Models\Role::where('name', 'pelamar')->first()->id;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
            'role_id' => $roleId,
        ]);
        // Auto-create blank profile after user registered
        
        \App\Models\Profile::create([
            'user_id' => $user->id,
            'full_name' => $request->name,
        ]);


        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
