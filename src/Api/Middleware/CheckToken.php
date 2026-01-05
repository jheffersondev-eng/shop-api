<?php

namespace Src\Api\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Src\Api\Responses\ApiResponse;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the Bearer token from the Authorization header
        $token = $request->bearerToken();

        // Check if token exists
        if (!$token) {
            \Illuminate\Support\Facades\Log::warning('Token não fornecido');
            return ApiResponse::unauthorized('Token não fornecido');
        }

        // Validate and authenticate the token
        try {
            $personalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            
            if (!$personalAccessToken || !$personalAccessToken->tokenable) {
                \Illuminate\Support\Facades\Log::warning('Token inválido: ' . substr($token, 0, 10));
                return ApiResponse::unauthorized('Token inválido ou expirado');
            }

            // Autenticar o usuário no guard padrão
            Auth::setUser($personalAccessToken->tokenable);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao validar token: ' . $e->getMessage());
            return ApiResponse::unauthorized('Erro ao validar token');
        }

        return $next($request);
    }
}
