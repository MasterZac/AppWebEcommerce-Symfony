<?php

namespace App\Controller\Registro;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/registro/user', name: 'userRegistro')]
    public function userRegistro(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $registration_form = $this->createForm(UserType::class, $user);
        $registration_form->handleRequest($request);
        if($registration_form->isSubmitted() && $registration_form->isValid()){
            $plaintextPassword = $registration_form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);
            $this->em->persist($user);
            $this->em->flush();
            return new RedirectResponse($this->generateUrl('app_login'));
            // return $this->redirectToRoute('userRegistro');
        }
        return $this->render('registro/user/index.html.twig', [
            'registration_form' => $registration_form->createView()
        ]);
    }

    #[Route('/registro/{id}', name: 'app_user')]
    public function show(User $user): Response
    {
        return $this->render('registro/index.html.twig', [
            'user' => $user,
        ]);
    }
}
