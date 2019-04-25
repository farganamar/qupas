<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\Auth;

class APILoginController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $get_id = User::where('email' , $request->email)->first();
        User::find($get_id->id)->update([
            'api_token' => $token,
        ]);
        return response()->json(compact('token'));
        // return redirect()->route('dashboard');
        // return view('home', compact('token'));
    }
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $delete_token = User::find(auth()->user()->id)->update(['api_token' => ""]);
        // Invalidate the token
        try {
            JWTAuth::invalidate();
            return response()->json([
                'status' => 'success',
                'message' => "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }
}
