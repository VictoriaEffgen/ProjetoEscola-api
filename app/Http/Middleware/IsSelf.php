<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSelf
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route()->parameter('id');
        $route = $request->route()->action['prefix'];

        $erro = 0;

        if(str_contains($route, 'user') && auth()->user()->id != $id && !auth()->user()->coordinator) {
            $erro++;
        }

        if(str_contains($route, 'student') && auth()->user()->student?->id != $id && !auth()->user()->teacher && !auth()->user()->coordinator) {
            $erro++;
        }

        if(str_contains($route, 'teacher') && auth()->user()->teacher?->id != $id && !auth()->user()->coordinator) {
            $erro++;
        }

        if(str_contains($route, 'coordinator') && auth()->user()->coordinator?->id != $id) {
            $erro++;
        }

        if($erro != 0) {
            return response()->json(['message' => 'Permissão de acesso negada'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
