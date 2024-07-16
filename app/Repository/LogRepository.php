<?php

namespace App\Repository;

use App\Models\Log;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class LogRepository {
    public function __construct(private readonly Log $model)
    {

    }

    public function single(int $id)  : JsonResponse {
        $log = $this->model->find($id);
        if (!isset($log)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse registro');
        }
        return response()->json([
            'log' => $log
        ], Response::HTTP_OK);
    }

    public function all()  : JsonResponse {
        $logs = $this->model->all();

        return response()->json([
            'list' => $logs
        ], Response::HTTP_OK);
    }
}
