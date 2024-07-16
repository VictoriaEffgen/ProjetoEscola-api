<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Repository\TeacherRepository;
use App\Service\TeacherService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TeacherController extends Controller
{
    public function __construct(
        private readonly TeacherService $service,
        private readonly TeacherRepository $repository
    ) {}

    public function create(TeacherRequest $request) : JsonResponse{
        try {
            return $this->service->create(request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao criar professor'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function single($id) : JsonResponse{
        try{
            return $this->repository->single($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar informações do professor'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function all() : JsonResponse{
        try{
            return $this->repository->all();
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao listar os professores'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, TeacherRequest $request) : JsonResponse{
        try {
            return $this->service->update($id, request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao atualizar professor'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function delete($id) : JsonResponse{
        try {
            return $this->service->delete($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao deletar professor'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
