<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use Symfony\Component\HttpFoundation\Response;

class AuthJWT extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        try {
            $this->authenticate($request, $guards);
        } catch(\Exception $e){
            if($e instanceof TokenInvalidException) {
                return response()->json([
                    'status' => 'Token Inválido'
                ], Response::HTTP_UNAUTHORIZED);
            }

            if($e instanceof TokenExpiredException) {
                return response()->json([
                    'status' => 'Token Expirado'
                ], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'status' => 'Token não encontrado'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
