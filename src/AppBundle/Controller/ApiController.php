<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

abstract class ApiController extends FOSRestController
{
    use ControllerTrait;

    protected function errorNotFound($message = null, $code = 404)
    {
        if ($message === null) {
            $translator = $this->get('translator.default');
            $message = $translator->trans('api.not_found', [], 'errors');
        }

        return $this->errorResponse($message, $code);
    }
}
