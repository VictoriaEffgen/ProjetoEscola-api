<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class UserService {
    public function __construct(private readonly User $model)
    {

    }

    public function create(array $data) : JsonResponse {
        $data["password"] = Hash::make($data['password']);
        $user = $this->model->create($data);

        return response()->json([
            'status' => 'Sucesso',
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function update(int $id, array $data) : JsonResponse {
        $user = $this->model->find($id);
        if (!isset($user)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse usuário');
        }

        $data["password"] = Hash::make($data['password']);
        $user->fill($data);
        $user->save();

        return response()->json([
            'status' => 'Sucesso',
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function delete(int $id) : JsonResponse {
        $user = $this->model->find($id);
        if (!isset($user)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse usuário');
        }
        $user->delete();

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Deletado com sucesso'
        ], Response::HTTP_OK);
    }

}
