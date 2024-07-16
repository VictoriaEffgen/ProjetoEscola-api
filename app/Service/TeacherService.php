<?php

namespace App\Service;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class TeacherService {
    public function __construct(
        private readonly Teacher $model,
        private readonly User $userModel
    )
    {

    }

    public function create(array $data) : JsonResponse {
        $user = $this->userModel->find($data['user_id']);
        if ($user->type != null){
            throw new InvalidArgumentException('Esse usuário ja foi classificado');
        }

        return DB::transaction(function () use($data, $user) {
            $teacher = $this->model->create($data);
            $user->type = 'teacher';
            $user->save();

            return response()->json([
                'status' => 'Sucesso',
                'teacher' => $teacher
            ], Response::HTTP_CREATED);
        });
    }

    public function update(int $id, array $data) : JsonResponse {
        $teacher = $this->model->find($id);
        if (!isset($teacher)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse professor');
        }

        $teacher->fill($data);
        $teacher->save();

        return response()->json([
            'status' => 'Sucesso',
            'teacher' => $teacher
        ], Response::HTTP_OK);
    }

    public function delete(int $id) : JsonResponse {
        $teacher = $this->model->find($id);
        if (!isset($teacher)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse professor');
        }

        $user = $this->userModel->find($teacher->user_id);
        if (!isset($user)){
            throw new InvalidArgumentException('Não foi possível encontrar o usuário associado');
        }

        return DB::transaction(function () use($teacher, $user) {
            $teacher->delete();
            $user->type = null;
            $user->save();

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Deletado com sucesso'
            ], Response::HTTP_OK);
        });
    }

}
