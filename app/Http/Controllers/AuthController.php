<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation', $validator->errors());
        }

        $checkEmail = User::where('email', $input['email'])->first();
        if ($checkEmail) {
            return $this->errorResponse('Email Already Existed');
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $response = [
            'token' => $user->createToken('rizkitirta')->plainTextToken,
            'name' => $user->name,
            'email' => $user->email
        ];

        return $this->successResponse($response, 'User Successfully Registered');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation', $validator->errors());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            $response = [
                'token' => $user->createToken('rizkitirta')->plainTextToken,
                'name' => $user->name,
                'email' => $user->email
            ];

            return $this->successResponse($response, 'You are Loged');
        } else {
            return $this->errorResponse('Your email or password is not valid!');
        }
    }
}
