<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ControllerTrait
{
    protected function errorResponse($message, $code)
    {
        return JsonResponse::create(
            [
                'code'    => $code,
                'message' => $message,
            ],
            $code
        );
    }
}