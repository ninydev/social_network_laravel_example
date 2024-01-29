<?php

namespace App\Services;

use App\Http\Resources\Auth\SuccessLoginResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OAT;

class JwtService
{

    public function guardApi(array $data)
    {
        $token = Auth::guard('api')->attempt($data);
        return $token;
    }

    public function buildResponse(string|null $token)
    {
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        return new SuccessLoginResource(
            [
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                ]
            ]
        );
//        return response()->json([
//            'status' => 'success',
//            'user' => $user,
//            'authorisation' => [
//                'token' => $token,
//                'type' => 'bearer',
//            ]
//        ]);
    }
}
