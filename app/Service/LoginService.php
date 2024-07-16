<?php

namespace App\Service;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LoginService {
    public function __construct()
    {
        //Qualquer coisa
    }

    public function auth(array $credential): JsonResponse {
        if(!$token = auth(guard: 'api')->attempt($credential)) {
            return response()->json([], Response::HTTP_BAD_REQUEST);
        }

        if(auth()->user()->type == null){
            auth()->logout();

            return response()->json([
                'message' => 'Aguardando aprovação do coordenador'
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json([
            'token' => $token
        ], Response::HTTP_OK);
    }

    public function logout() : JsonResponse {
        try {
            auth(guard: 'api')->logout();
            return response()->json(['message' => 'Deslogado'], Response::HTTP_OK);
        } catch (Throwable $exception){
            if ($exception instanceof JWTException) {
                return response()->json(['message' => 'Deslogado'], Response::HTTP_OK);
            }
        }
    }

    public function refresh() : JsonResponse {
        try {
            $token = JWTAuth::getToken();
            $token = JWTAuth::refresh($token);
            return response()->json([
                'token' => $token
            ], Response::HTTP_OK);
        } catch (Throwable $exception) {
            return response()->json([], Response::HTTP_BAD_REQUEST);
        }
    }
}
