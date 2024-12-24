<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    /**
     * Provides a request payload
     * @return array<mixed>
     */
    protected function getRequestPayload(Request $request): array
    {
        if ('json' !== $request->getContentTypeFormat()) {
            return [];
        }

        return $request->toArray();
    }
}