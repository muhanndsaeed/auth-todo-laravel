<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    //
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
            'confirm_password'=>'required|same:password',
        ]);
        if($validator->fails()){
            return $this->handleError($validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('myapptoken',expiresAt:now()->addDay())->plainTextToken;
        $success['name']= $user->name;

        return $this->handleResponse($success,'User successfully registered');
    }

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $auth = Auth::user();
            $success['token'] = $auth->createToken('myapptoken',expiresAt:now()->addDay())->plainTextToken;
            $success['name']= $auth->name;
            return $this->handleResponse($success,'User logged in!');
        }else {
            return $this->handleError('Unauthorised',['error'=>'Unauthorised']);

        }
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message'=>'Logged out',
        ]);
    }
}
