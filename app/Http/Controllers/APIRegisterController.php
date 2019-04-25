<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Facades\Hash;

class APIRegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'saldo' => 100000,
            'api_token' => 0,
        ]);
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        User::find($user->id)->update([
            'api_token' => $token,
        ]);

        return Response::json(compact('token'));

    }
}
