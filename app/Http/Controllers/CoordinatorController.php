<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoordinatorRequest;
use App\Repository\CoordinatorRepository;
use App\Service\CoordinatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CoordinatorController extends Controller
{
    public function __construct(
        private readonly CoordinatorService $service,
        private readonly CoordinatorRepository $repository
    ) {}

    public function create(CoordinatorRequest $request) : JsonResponse{
        try {
            return $this->service->create(request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao criar coordenador'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function single($id) : JsonResponse{
        try{
            return $this->repository->single($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar informações do coordenador'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function all() : JsonResponse{
        try{
            return $this->repository->all();
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao listar os coordenadores'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete($id) : JsonResponse{
        try {
            return $this->service->delete($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao deletar coordenador'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
