<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Service\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $service
    )
    {}

    public function auth(LoginRequest $request) : JsonResponse{
        return $this->service->auth(request()->all());
    }

    public function logout() {
        return $this->service->logout();
    }

    public function refresh() {
        return $this->service->refresh();
    }
}
