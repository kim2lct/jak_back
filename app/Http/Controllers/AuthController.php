<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){        

        try {
        $validated = $request->validate([
            'name'=>'required|string',
            'email'=>'required|unique:users,email',
            'password'=>'required|confirmed'            
        ]); 
                        
                    } catch (\Exception $e) {
                        return response([
            'message'=>$e->getMessage(),
        ],401);
                    }          


        $user = User::create([
            'name'=>$validated['name'],
            'email'=>$validated['email'],
            'password'=>Hash::make($validated['password'])
        ]);

        $user->roles()->create([
            'role_id'=>2,            
        ]);

        return response([
            'user'=>$user,
        ],201);
    }

    public function login(Request $request){
        
        $validated = $request->validate([            
            'email'=>'required',
            'password'=>'required'
        ]);


        $credentials = $request->only('email', 'password');        
            if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();                        
            $user = User::where('email',$request->email)->with('roles')->first();
            $token = $user->createToken('jakToken')->plainTextToken;
            return response([
                'user'=>$user,                
                '_token'=>$token,
            ],201);
        }else{
            return response([
                'message'=>'Bad Request'
            ],401);
        }
        
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
                'message'=>'You was logout!'
            ],401);
    }
}
