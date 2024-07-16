<?php

namespace App\Service;

use App\Models\Grades;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class GradesService {
    public function __construct(
        private readonly Grades $model
    )
    {

    }

    public function create(array $data) : JsonResponse {
        $theme = Teacher::find($data['teacher_id'])->theme;
        $serie = Student::find($data['student_id'])->serie;
        $data['theme'] = $theme;
        $data['serie'] = $serie;

        $grades = $this->model->create($data);
        return response()->json([
            'status' => 'Sucesso',
            'grades' => $grades
        ], Response::HTTP_CREATED);
    }

    public function update(int $id, array $data) : JsonResponse {
        $grades = $this->model->find($id);
        if (!isset($grades)) {
            throw new InvalidArgumentException('Não foi possivel encontrar essa nota');
        }

        $grades->fill($data);
        $grades->save();

        return response()->json([
            'status' => 'Sucesso',
            'grades' => $grades
        ], Response::HTTP_OK);
    }

    public function delete(int $id) : JsonResponse {
        $grades = $this->model->find($id);
        if (!isset($grades)) {
            throw new InvalidArgumentException('Não foi possivel encontrar essa nota');
        }
        $grades->delete();

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Deletado com sucesso'
        ], Response::HTTP_OK);
    }

}
