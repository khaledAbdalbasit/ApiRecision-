<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => ['required','string', 'max:255'],
            'email' => ['required','email','unique:users'],
            'password' =>['required', Rules\password::defaults()],
        ]);

        if($validator->fails()){
            return ApiResponse::sendResponse(Response::HTTP_UNPROCESSABLE_ENTITY,'Registeration validation error',$validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $data['token'] = $user->createToken('API TOKEN')->plainTextToken;
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        return ApiResponse::sendResponse(Response::HTTP_CREATED,'User created successfully',$data);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => ['required','email'],
            'password' =>['required', Rules\password::defaults()],
        ]);

        if($validator->fails()){
            return ApiResponse::sendResponse(Response::HTTP_UNPROCESSABLE_ENTITY,'Login validation error',$validator->errors());
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $data['token'] = $user->createToken('API TOKEN')->plainTextToken;
            $data['name'] = $user->name;
            $data['email'] = $user->email;

            return ApiResponse::sendResponse(Response::HTTP_CREATED,'User Loged in successfully',$data);
        }
        return ApiResponse::sendResponse(Response::HTTP_UNAUTHORIZED,' these credentials do not match our records.',[]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(Response::HTTP_OK,'User Loged out successfully',[]);
    }
}
