<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\JwtService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAT;

/*
 *     requestBody: new OAT\RequestBody(
        required: true,
        content: new OAT\JsonContent(ref: '#/components/schemas/LoginRequest')

    ),

 */

/*
    responses: [
        new OAT\Response(
            response: HttpResponse::HTTP_OK,
            description: 'Ok',
            content: new OAT\JsonContent(ref: '#/components/schemas/LoggedInUserResource')
        ),
        new OAT\Response(
            response: HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
            description: 'Unprocessable entity',
            content: new OAT\JsonContent(ref: '#/components/schemas/ValidationError')
        ),
        new OAT\Response(
            response: HttpResponse::HTTP_UNAUTHORIZED,
            description: 'Unauthorized',
            content: new OAT\JsonContent(
                properties: [
                    new OAT\Property(
                        property: 'message',
                        type: 'string',
                        example: 'Invalid credentials.'
                    ),
                ]
            )
        ),
    ]
 */
#[OAT\Post(
    tags: ['auth'],
    path: '/api/auth/register',
    summary: 'Register a user',
    operationId: 'api.auth.register',
    requestBody: new OAT\RequestBody(
        required: true,
    ),
    responses: [
        new OAT\Response(
            response: 200,
            description: 'Ok',
        )]
)]
class RegisterController extends Controller
{
    public function __construct(
        private UserService $userService,
        private JwtService $jwtService,
    )
    {
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $this->userService->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
        $token = $this->jwtService->guardApi([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return $this->jwtService->buildResponse($token);
    }

}
