<?php

namespace App\Service;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class StudentService {
    public function __construct(
        private readonly Student $model,
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
            $student = $this->model->create($data);
            $user->type = 'student';
            $user->save();

            return response()->json([
                'status' => 'Sucesso',
                'student' => $student
            ], Response::HTTP_CREATED);
        });
    }

    public function update(int $id, array $data) : JsonResponse {
        $student = $this->model->find($id);
        if (!isset($student)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse aluno');
        }

        $student->fill($data);
        $student->save();

        return response()->json([
            'status' => 'Sucesso',
            'student' => $student
        ], Response::HTTP_OK);
    }

    public function delete(int $id) : JsonResponse {
        $student = $this->model->find($id);
        if (!isset($student)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse aluno');
        }

        $user = $this->userModel->find($student->user_id);
        if (!isset($user)){
            throw new InvalidArgumentException('Não foi possível encontrar o usuário associado');
        }

        return DB::transaction(function () use($student, $user) {
            $student->delete();
            $user->type = null;
            $user->save();

            return response()->json([
                'status' => 'Sucesso',
                'message' => 'Deletado com sucesso'
            ], Response::HTTP_OK);
        });
    }

}
