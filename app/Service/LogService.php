<?php

namespace App\Service;

use App\Models\Log;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class LogService {
    public function __construct(
        private readonly Log $model,
    )
    {

    }

    public function create(array $data) : JsonResponse {
        $log = $this->model->create($data);
        return response()->json([
            'status' => 'Sucesso',
            'log' => $log
        ], Response::HTTP_CREATED);
    }

    public function update(int $id, array $data) : JsonResponse {
        $log = $this->model->find($id);
        if (!isset($log)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse registro');
        }

        $log->fill($data);
        $log->save();

        return response()->json([
            'status' => 'Sucesso',
            'log' => $log
        ], Response::HTTP_OK);
    }

    public function delete(int $id) : JsonResponse {
        $log = $this->model->find($id);
        if (!isset($log)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse registro');
        }
        $log->delete();
        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Deletado com sucesso'
        ], Response::HTTP_OK);
    }

}
