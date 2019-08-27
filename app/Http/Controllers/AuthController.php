<?php

namespace App\Http\Controllers;

use App\User;
use JWTAuth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer'
//            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json(["data" => $users]);
    }

    public function refreshToken()
    {
        $token = auth()->getToken();
        if(!$token){
            throw new BadRequestHtttpException('Token not provided');
        }
        try{
            $token = auth()->refresh($token);
        }catch(TokenInvalidException $e){
            throw new AccessDeniedHttpException('The token is invalid');
        }
        return response()->json(["token" => $token]);

    }

}
