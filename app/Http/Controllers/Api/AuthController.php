<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors()->toArray(), [], 400);
            }
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->sendErrorResponse('The provided credentials are incorrect.', [], 400);
            }
            $token = $user->createToken('api_token')->plainTextToken;
            $user = $user->toApiArray();
            $user['token'] =  $token;
            if (!empty($user) && $request->fcm_token != '') {
                User::where('id', $user['id'])->update([
                    'fcm_token' => $request->fcm_token
                ]);
            }
           return response()->json([
                        'success' => true,
                        'message' => 'User Logged in successfully',
                        'data'    => $user,
                    ], 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), [], 500);
        }

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user || !$user->currentAccessToken()) {
            return response()->json(['message' => 'User already logged out'], 200);
        }
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
