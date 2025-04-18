<?php

namespace App\Http\Controllers;

use App\Models\SubDomains\User;
use App\Models\ValueObjects\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserAuthController extends Controller
{
    protected array $needs_filter = [
        'name',
        'description'
    ];

    public function index()
    {
        return User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'permissions' => $user->permissions,
            ];
        });
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $sanitizedText = apply_filters($this->needs_filter, $request->all());

        User::create([
            'name' => $sanitizedText['name'],
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::fromArray(strtoupper(Role::ROLES[$request->role])),
            'permissions' => '{"projects": [], "companies": []}'
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $sanitizedText = apply_filters($this->needs_filter, $request->all());

        $user = User::create([
            'name' => $sanitizedText['name'],
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::fromArray('USER'),
        ]);

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response()->json([
            'message' => 'User Created ',
            'access_token' => $token,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'string',
                Rule::unique('users')->ignore($request->id),
            ],
            'role' => 'required|in:' . implode(',', array_keys(Role::ROLES)),
            'name' => 'required|string',
            'description' => 'string',
            'permissions' => 'json'
        ]);

        $user = User::findOrFail($request->id);
        $sanitizedText = apply_filters($this->needs_filter, $request->all());

        if ($request->description) {
            $permissions = json_decode($user->permissions);
            $permissions->description = $sanitizedText['description'];
            $user->permissions = json_encode($permissions);
        } else {
            $user->permissions = $request->permissions;
        }
        $user->update([
            'name' => $sanitizedText['name'],
            'email' => $request->email,
            'role' => Role::fromArray($request->role)
        ]);
        return response('User Updated successfully', 200);

    }

    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $loginUserData['email'])->first();
        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ]);
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        return response('User deleted successfully', 200);
    }
}
