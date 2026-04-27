<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\MessageBag;

final class ValidationResponse implements Responsable
{
    /**
     * Validation error messages.
     */
    private MessageBag $errors;

    /**
     * ValidationResponse constructor.
     */
    public function __construct(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Converts the response to a JSON response.
     *
     * @param  mixed  $request
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'result' => [
                    'message' => __(key: 'Validation error.'),
                    'errors' => $this->errors,
                ],
            ],
            status: Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
