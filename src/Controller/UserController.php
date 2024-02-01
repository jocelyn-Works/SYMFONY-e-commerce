<?php

namespace App\Controller;

use App\Entity\DescriptionUser;
use App\Form\DescriptionUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(Request $request,
    UserInterface $user,
    EntityManagerInterface $em): Response
    {
       
        $newDescription = new DescriptionUser();

        $userForm = $this->createForm(DescriptionUserType::class, $newDescription);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $newDescription->setAuthor($user);

            $em->persist($newDescription);
            $em->flush();

            return $this->redirect($request->getUri());
        }
        return $this->render('user/index.html.twig', [
            'form' => $userForm->createView()
            
        ]);
    }
}
