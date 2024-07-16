<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogRequest;
use App\Repository\LogRepository;
use App\Service\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LogController extends Controller
{
    public function __construct(
        private readonly LogService $service,
        private readonly LogRepository $repository
    ) {}

    public function create(LogRequest $request) : JsonResponse{
        try {
            return $this->service->create(request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao criar registro'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function single($id) : JsonResponse{
        try{
            return $this->repository->single($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar informações de registro'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function all() : JsonResponse{
        try{
            return $this->repository->all();
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao listar registros'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, LogRequest $request) : JsonResponse{
        try {
            return $this->service->update($id, request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao atualizar registro'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function delete($id) : JsonResponse{
        try {
            return $this->service->delete($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao deletar registro'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
