<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if ($token = auth('api')->attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            return $this->respondWithToken($token, $user);
        }

        return response()->json(["message" => "Sorry, we couldn't find an account with this credential."], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->guard()->user());
    }

    /**
     * Register new user and authenticated User
     */

    public function register(Request $request){

        $request->validate([
            'name' => 'required|string',
            'user_id' => 'required|unique:admins',
            'password' => 'required|string|min:6|max:50'
        ]);

        User::create([
            'name'  => $request->name,
            'user_id'  => $request->user_id,
            'password'  => Hash::make($request->password),
        ]);

    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {   
        auth()->guard()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
            'user'  => $user
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    public function update(Request $request){

        $request->validate([
            'name' => 'required|string|max:32',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'password' => 'required',
        ]);

        if (Hash::check($request->password, auth()->user()->password)) {

            $profile = User::find($request->id);
            $profile->name = $request->name;
            $profile->email = $request->email;
            $profile->save();

        }else{
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['Password does not match.'],
                ],
            ], 422);
      }
    }

    public function changePassword(Request $request){

        $request->validate([
            'current_password'  =>  'required',
            'password'          =>  'required|string|min:8|confirmed',
        ]);

        if (Hash::check($request->current_password, auth()->user()->password)) {

          $user = User::find(auth()->user()->id);
          $user->password = Hash::make($request->password);
          $user->save();
          
        }else{
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'current_password' => ['Current Password does not match.'],
                ]
            ], 422);
        }
    }
}
