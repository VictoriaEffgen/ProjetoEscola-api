<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Repository\StudentRepository;
use App\Service\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class StudentController extends Controller
{
    public function __construct(
        private readonly StudentService $service,
        private readonly StudentRepository $repository
    ) {}

    public function create(StudentRequest $request) : JsonResponse{
        try {
            return $this->service->create(request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao criar aluno'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function single($id) : JsonResponse{
        try{
            return $this->repository->single($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar informações do aluno'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function all() : JsonResponse{
        try{
            return $this->repository->all();
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao listar os alunos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, StudentRequest $request) : JsonResponse{
        try {
            return $this->service->update($id, request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao atualizar aluno'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function delete($id) : JsonResponse{
        try {
            return $this->service->delete($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao deletar aluno'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
