<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Infrastracture\Events\RegisterUserEvent;
use App\Models\SubDomains\User;
use App\Models\ValueObjects\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    private array $needs_filter = [
        'name'
    ];

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $sanitizedText = apply_filters($this->needs_filter, $request->all());

        $user = User::create([
            'name' => $sanitizedText['name'],
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
