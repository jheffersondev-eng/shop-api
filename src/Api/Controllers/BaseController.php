<?php

namespace Src\Api\Controllers;

use Src\Application\DTOs\ServiceResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

abstract class BaseController extends Controller
{
    /**
     * Executa uma operação de forma segura com transação de banco de dados
     *
     * @param callable $callback - Função que deve retornar um ServiceResult
     * @param int $statusCodeSuccess - Status HTTP para sucesso (padrão 200)
     * @param int $statusCodeError - Status HTTP para erro (padrão 400)
     * @return JsonResponse
     */
    protected function execute(
        callable $callback,
        int $statusCodeSuccess = 200,
        int $statusCodeError = 400
    ): JsonResponse {
        try {
            DB::beginTransaction();

            /** @var ServiceResult $result */
            $result = $callback();

            if (!$result->success) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => $result->message,
                ], $statusCodeError);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $result->data,
                'message' => $result->message
            ], $statusCodeSuccess);

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Erro na execução: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro interno ao processar a requisição',
            ], $statusCodeError);
        }
    }
}
