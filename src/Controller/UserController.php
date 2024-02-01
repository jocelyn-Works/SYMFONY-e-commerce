<?php

namespace App\Controller;

use App\Entity\DescriptionUser;
use App\Form\DescriptionUserType;
use App\Repository\DescriptionUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{


    #[Route('/user' , name:'user')]
    public function user (DescriptionUserRepository $descriptionRepository,
    UserInterface $currentUser):Response
    {

        $decriptions = $descriptionRepository->findUserDescription($currentUser);

        return $this->render('user/user.html.twig', [
            'descriptions' => $decriptions
        ]); 
    }


    #[Route('/user/description', name: 'user_description')]
    public function description(Request $request,
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

            return $this->redirectToRoute('user');
        }
        return $this->render('user/description.html.twig', [
            'form' => $userForm->createView()
            
        ]);
    }
    
}
