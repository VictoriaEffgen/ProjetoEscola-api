<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use App\Http\Requests\UserRequest;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service,
        private readonly UserRepository $repository
    ) {}

    public function create(UserRequest $request) : JsonResponse{
        try {
            return $this->service->create(request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao criar usuário'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function single($id) : JsonResponse{
        try{
            return $this->repository->single($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao buscar informações do usuário'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function all() : JsonResponse{
        try{
            return $this->repository->all();
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao listar os usuários'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, UserRequest $request) : JsonResponse{
        try {
            return $this->service->update($id, request()->all());
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao atualizar usuário'
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function delete($id) : JsonResponse{
        try {
            return $this->service->delete($id);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Falha ao deletar usuário'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
