<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradesRequest;
use App\Repository\GradesRepository;
use App\Service\GradesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class GradesController extends Controller
{
    public function __construct(
        private readonly GradesService $service,
        private readonly GradesRepository $repository
    ) {}

    public function create(GradesRequest $request) : JsonResponse{
        try {
            return $this->service->create(request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao lançar nota'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function update($id, GradesRequest $request) : JsonResponse{
        try {
            return $this->service->update($id, request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao atualizar nota'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function delete($id) : JsonResponse{
        try {
            return $this->service->delete($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao deletar nota'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function mySchoolReport($student_id) : JsonResponse{
        try{
            return $this->repository->mySchoolReport($student_id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar boletim do aluno'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function myGradesReleased($teacher_id) : JsonResponse{
        try{
            return $this->repository->myGradesReleased($teacher_id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar notas lançadas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function myClassAgenda($teacher_id, $serie) : JsonResponse{
        try{
            return $this->repository->myClassAgenda($teacher_id, $serie);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar pauta'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function classAgenda($serie) : JsonResponse{
        try{
            return $this->repository->classAgenda($serie);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar pauta'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
