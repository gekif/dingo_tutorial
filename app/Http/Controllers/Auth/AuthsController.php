<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Transformers\UserTransformer;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\JWTAuth;

class AuthsController extends Controller
{
    protected $userService;
    protected $authService;


    public function __construct(UserService $userService, JWTAuth $authService)
    {
        $this->userService = $userService;

        $this->authService = $authService;
    }


    public function login(Request $request)
    {
        $token = $this->authService->attempt(
            $request->only(['email', 'password'])
        );

        if (!$token)
            throw new UnauthorizedHttpException('jwt');

        return $this->success([
            'token' => $token
        ]);
    }


    public function refreshToken()
    {
        return $this->authService->parseToken()->refresh();
    }


    public function getUser(Request $request)
    {
        $user = $request->user();

        return $this->response->item($user, new UserTransformer());
    }


    public function register(Request $request)
    {
        $user = $this->userService->create($request->all());

        return $this->response->item($user, new UserTransformer());
    }

}
