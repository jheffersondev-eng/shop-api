<?php

namespace Src\Api\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Resposta de sucesso
     */
    public static function success(mixed $data = null, string $message = "Sucesso", int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Resposta de erro
     */
    public static function error(string $message = "Erro na operação", int $statusCode = 400, mixed $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Erro de autenticação (401)
     */
    public static function unauthorized(string $message = "Não autorizado"): JsonResponse
    {
        return self::error($message, 401);
    }

    /**
     * Erro de acesso proibido (403)
     */
    public static function forbidden(string $message = "Acesso proibido"): JsonResponse
    {
        return self::error($message, 403);
    }

    /**
     * Recurso não encontrado (404)
     */
    public static function notFound(string $message = "Recurso não encontrado"): JsonResponse
    {
        return self::error($message, 404);
    }

    /**
     * Erro de validação (422)
     */
    public static function validationError(array $errors, string $message = "Erro de validação"): JsonResponse
    {
        return self::error($message, 422, $errors);
    }

    /**
     * Erro de servidor (500)
     */
    public static function serverError(string $message = "Erro interno do servidor"): JsonResponse
    {
        return self::error($message, 500);
    }
}
