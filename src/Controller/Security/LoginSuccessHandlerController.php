<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandlerController implements AuthenticationSuccessHandlerInterface
{
    private $router;
    private $security;

    public function __construct(UrlGeneratorInterface $router, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        // Obtiene los roles del usuario autenticado
        $user = $this->security->getUser();

        // Verifica los roles del usuario y redirige en consecuencia
        if ($user && in_array('ROLE_ADMIN', $user->getRoles(), true)){
            $redirectUrl = $this->router->generate('dashboard_admin');
        } else{
            $redirectUrl = $this->router->generate('app_inicio');
        }

        return new RedirectResponse($redirectUrl);
    }
}
