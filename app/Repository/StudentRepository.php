<?php

namespace App\Repository;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class StudentRepository {
    public function __construct(private readonly Student $model)
    {

    }

    public function single(int $id)  : JsonResponse {
        $student = $this->model->with('user')->find($id);
        if (!isset($student)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse aluno');
        }
        return response()->json([
            'student' => $student
        ], Response::HTTP_OK);
    }

    public function all()  : JsonResponse {
        $students = $this->model->all();

        return response()->json([
            'list' => $students
        ], Response::HTTP_OK);
    }
}
