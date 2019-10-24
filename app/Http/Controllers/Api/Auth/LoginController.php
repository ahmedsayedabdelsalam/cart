<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function action(Request $request)
    {
        if (!$token = auth('api')->attempt($request->only(['email', 'password']))) {
            return json()->response([
                'errors' => [
                    'email' => 'could not sign you in with those details.'
                ]
                ], 422);
        }

        return (new PrivateUserResource(auth('api')->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }
}
