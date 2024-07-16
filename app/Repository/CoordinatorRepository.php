<?php

namespace App\Repository;

use App\Models\Coordinator;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class CoordinatorRepository {
    public function __construct(private readonly Coordinator $model)
    {

    }

    public function single(int $id)  : JsonResponse {
        $coordinator = $this->model->with('user')->find($id);
        if (!isset($coordinator)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse coordenador');
        }
        return response()->json([
            'coordinator' => $coordinator
        ], Response::HTTP_OK);
    }

    public function all()  : JsonResponse {
        $coordinator = $this->model->all();

        return response()->json([
            'list' => $coordinator
        ], Response::HTTP_OK);
    }
}
