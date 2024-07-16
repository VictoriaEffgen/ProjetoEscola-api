<?php

namespace App\Service;

use App\Models\Coordinator;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class CoordinatorService {
    public function __construct(
        private readonly Coordinator $model,
        private readonly User $userModel
    )
    {}

    public function create(array $data) : JsonResponse {
        $user = $this->userModel->find($data['user_id']);
        if ($user->type != null){
            throw new InvalidArgumentException('Esse usuário ja foi classificado');
        }

        return DB::transaction(function () use($data, $user) {
            $coordinator = $this->model->create($data);
            $user->type = 'coordinator';
            $user->save();

            return response()->json([
                'status' => 'Sucesso',
                'coordinator' => $coordinator
            ], Response::HTTP_CREATED);
        });
    }

    public function delete(int $id) : JsonResponse {
        $coordinator = $this->model->find($id);
        if (!isset($coordinator)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse coordenador');
        }

        $user = $this->userModel->find($coordinator->user_id);
        if (!isset($user)){
            throw new InvalidArgumentException('Não foi possível encontrar o usuário associado');
        }

        return DB::transaction(function () use($coordinator, $user) {
            $coordinator->delete();
            $user->type = null;
            $user->save();

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Deletado com sucesso'
            ], Response::HTTP_OK);
        });
    }
}
