<?php

namespace App\Repository;

use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class TeacherRepository {
    public function __construct(private readonly Teacher $model)
    {

    }

    public function single(int $id)  : JsonResponse {
        $teacher = $this->model->with('user')->find($id);
        if (!isset($teacher)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse professor');
        }
        return response()->json([
            'teacher' => $teacher
        ], Response::HTTP_OK);
    }

    public function all()  : JsonResponse {
        $teachers = $this->model->all();

        return response()->json([
            'list' => $teachers
        ], Response::HTTP_OK);
    }
}
