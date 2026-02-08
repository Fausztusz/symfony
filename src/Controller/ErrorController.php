<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ErrorController extends AbstractController
{

    #[Route('/error/{code<\d*>}', name: 'error')]
    public function error($code, Request $request): Response
    {
        $code = $code ?: Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $request->query->getString('message', 'Server error');
        return $this->render('error.html.twig', [
            'code' => $code,
            'message' => $message,
        ]);
    }
}
