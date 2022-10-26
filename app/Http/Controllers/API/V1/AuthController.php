<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|string|min:6',
            'abilities' => 'nullable|array'
        ]);

        $user = User::where('username', $request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            
            $device_name =  $request->userAgent();
            $token = $user->createToken($device_name, $request->post('abilities'));

            return Response::json([
                'code' => 1,
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);

        }

        return Response::json([
            'code' => 0,
            'message' => 'Invalid credentials',
        ], 401);
        
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();


        // Revoke all tokens
        // $user->tokens()->delete();

        if (null === $token) {
            $user->currentAccessToken()->delete();
            return;
        }

        $personalAccessToken = PersonalAccessToken::findToken($token);
        if (
            $user->id == $personalAccessToken->tokenable_id 
            && get_class($user) == $personalAccessToken->tokenable_type
        ) {
            $personalAccessToken->delete();
        }
    }
}
