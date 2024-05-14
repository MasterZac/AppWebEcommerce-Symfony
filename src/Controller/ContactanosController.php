<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactanosController extends AbstractController
{
    #[Route('/contactanos', name: 'app_contactanos')]
    public function index(): Response
    {
        return $this->render('contactanos/index.html.twig', [
            'controller_name' => 'ContactanosController',
        ]);
    }
}
