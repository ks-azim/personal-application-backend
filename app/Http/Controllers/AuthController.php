<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;

class AuthController extends Controller
{ 
    public function login()
    {
        try {
            $validate = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function settings()
    {
        
    }

    public function verifyEmail(Request $request) 
    {
        // verify if the given email exists 
        $user = User::where('email', $request->email)->first();

        if($user) {
           // Generate token 
           DB::table('password_resets')->insert([
              'email' => $user->email,
              'token' => time()
           ]);

           // send email with a verification code
           // redirect to code reciever page 

           return response()->json([
            'status'  => 200
           ]);
        } else {
            return response()->json([
                'status'  => 404,
                'message' => 'The given email does not exist in our system'
            ]);
        }
    }

    public function codeVerification(Request $request) 
    {
        $user = DB::table('password_resets')->where('email', $request->email)->first();

        // match verification code , then proceed to password reset page 

        if($request->token == $user->token) {
            return response()->json([
                'status'  => 200
            ]);
        } else {
            return response()->json([
                'status'  => 401,
                'message' => 'Incorrect Token !'
            ]);
        }

        // after reseting password, proceed to the login page 
    }

    public function resetPassword(Request $request) 
    {
        $user = DB::table('password_resets')->where('email', $request->email)->first();

        // match verification code , then proceed to password reset page 

        if($request->token == $user->token) {
            User::where('email', $request->email)->update([
                'password' => $request->password
            ]);

            // after reseting password, proceed to the login page 
            return response()->json([
                'status'  => 200,
                'message' => 'Password reset succesfully !'
            ]);
        } else {
            return response()->json([
                'status'  => 401,
                'message' => 'Unauthorized !'
            ]);
        }
    }
}
