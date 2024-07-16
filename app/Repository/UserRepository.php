<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class UserRepository {
    public function __construct(private readonly User $model)
    {

    }

    public function single(int $id)  : JsonResponse {
        $user = $this->model->find($id);
        if (!isset($user)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse usuário');
        }
        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function all()  : JsonResponse {
        $users = $this->model->all();

        return response()->json([
            'list' => $users
        ], Response::HTTP_OK);
    }
}
