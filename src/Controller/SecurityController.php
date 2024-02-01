<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class SecurityController extends AbstractController
{

private EntityManagerInterface $em;

    public function __construct(private $formLoginAuthenticator,EntityManagerInterface $em)
    {  
        $this->em = $em;
    }

    #[Route('/signup', name: 'signup')]
    public function signup(Request $request,
    UserPasswordHasherInterface $passwordHasher,
    UserAuthenticatorInterface $userAuthenticator
    ): Response
    {
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {

            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);

            $this->em->persist($user);
            $this->em->flush();

                // Connexion de l'utilisateur aprés inscription
            return $userAuthenticator->authenticateUser($user, $this->formLoginAuthenticator, $request);

        }

        return $this->render('security/signup.html.twig', [
            'form' => $userForm->createView()
        ]);
    }

     
    #[Route('/login', name: 'login')]
    public function login(
        AuthenticationUtils $authenticationUtils
    ): Response
    {
         // erreur dauthentification 
         $error = $authenticationUtils->getLastAuthenticationError();
         // récupère le nom entré par l'utilisateur lors de la derniére connxion
         $username = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {  
    }

    
}
