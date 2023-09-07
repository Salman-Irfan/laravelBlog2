<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule; // use rule class for validation
class UserController extends Controller
{
    //function to register users
    public function register(Request $request){
        // catch the request data and apply validations
        $validatedData = $request->validate([
            // define validation rules for user registration
            'name' =>'required',
            'email' =>['required', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed'],
        ]);

        // create the user from valdated data
        $user = User::create($validatedData);

        // create token for registered user
        $token = $user->createToken("auth_token")->accessToken;

        // return the newly created user with the token
        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'user created successfully',
            "status" => 1
        ]);
    }
}
