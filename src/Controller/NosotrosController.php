<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NosotrosController extends AbstractController
{
    #[Route('/nosotros', name: 'app_nosotros')]
    public function index(): Response
    {
        return $this->render('nosotros/index.html.twig', [
            'controller_name' => 'NosotrosController',
        ]);
    }
}
