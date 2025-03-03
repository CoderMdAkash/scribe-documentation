<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @group Authentication
 *
 * APIs for user authentication
 */
class AuthController extends Controller
{
    /**
     * Login
     *
     * Authenticates a user using email and password and returns an API token.
     *
     * @bodyParam email string required The email of the user. Example: johndoe@example.com
     * @bodyParam password string required The password of the user. Example: secret123
     *
     * @response 200 {
     *   "token": "your_generated_token_here"
     * }
     * @response 401 {
     *   "error": "Your Email Password Not Correct!"
     * }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->accessToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Email or Password Invalid!'], 401);
    }

    /**
     * User Details
     *
     * Retrieves the currently authenticated user.
     *
     * @authenticated
     * @header Authorization Bearer {token}
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "johndoe@example.com"
     * }
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    /**
     * Logout
     *
     * Logout the currently authenticated user.
     *
     * @authenticated
     * @header Authorization Bearer {token}
     *
     * @response 200 {
     *   "message": "Logged out successfully",
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
