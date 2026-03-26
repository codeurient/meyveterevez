<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function store(LoginRequest $request, LoginAction $action): JsonResponse
    {
        try {
            $action->execute(
                $request,
                $request->validated('email'),
                $request->validated('password'),
                (bool) $request->validated('remember'),
            );
        } catch (ValidationException $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage(),
                'errors'  => $e->errors(),
            ], 422);
        }

        $token = $request->user()->createToken('api-token')->plainTextToken;

        return new JsonResponse([
            'success' => true,
            'token'   => $token,
            'user'    => [
                'id'         => $request->user()->id,
                'name'       => $request->user()->name,
                'email'      => $request->user()->email,
                'avatar_url' => $request->user()->avatar_url,
            ],
        ]);
    }

    public function destroy(Request $request, LogoutAction $action): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();
        $action->execute($request);

        return new JsonResponse(['success' => true]);
    }
}
