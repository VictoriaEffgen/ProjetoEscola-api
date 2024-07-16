<?php

namespace App\Repository;

use App\Models\Grades;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class GradesRepository {
    public function __construct(private readonly Grades $model)
    {

    }

    public function mySchoolReport(int $student_id)  : JsonResponse {
        $grades = $this->model->where('student_id',$student_id)
            ->orderBy('quarter')
            ->get();
        if (!isset($grades)) {
            throw new InvalidArgumentException('Não foi possivel encontrar esse boletim');
        }
        return response()->json([
            'grades' => $grades
        ], Response::HTTP_OK);
    }

    public function myGradesReleased(int $teacher_id)  : JsonResponse {
        $grades = $this->model->where('teacher_id',$teacher_id)
            ->orderBy('quarter')
            ->orderBy('serie')
            ->get();
        if (!isset($grades)) {
            throw new InvalidArgumentException('Não foi possivel encontrar notas lançadas');
        }
        return response()->json([
            'grades' => $grades
        ], Response::HTTP_OK);
    }

    public function myClassAgenda(int $teacher_id, int $serie)  : JsonResponse {
        $grades = $this->model->where('teacher_id',$teacher_id)
            ->where('serie', $serie)
            ->orderBy('quarter')
            ->get();
        if (!isset($grades)) {
            throw new InvalidArgumentException('Não foi possivel encontrar pauta');
        }
        return response()->json([
            'grades' => $grades
        ], Response::HTTP_OK);
    }

    public function classAgenda(int $serie)  : JsonResponse {
        $grades = $this->model->where('serie', $serie)
            ->orderBy('theme')
            ->get();
        if (!isset($grades)) {
            throw new InvalidArgumentException('Não foi possivel encontrar pauta');
        }
        return response()->json([
            'grades' => $grades
        ], Response::HTTP_OK);
    }
}
