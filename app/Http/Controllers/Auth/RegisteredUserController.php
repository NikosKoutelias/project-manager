<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Infrastracture\Events\RegisterUserEvent;
use App\Models\SubDomains\User;
use App\Models\ValueObjects\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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
    public function store(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::fromArray('USER'),
            'permissions' => json_encode(['projects' => [], 'companies' => []])
        ]);

        event(new Registered($user));

        try {
            event(new RegisterUserEvent($user));
        } catch (\Exception $exception) {
            logger('Register User Event failed to broadcast: ' . $exception->getMessage());
        }

        Auth::login($user);

        return response()->noContent();
    }
}
