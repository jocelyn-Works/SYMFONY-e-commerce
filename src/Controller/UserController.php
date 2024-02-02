<?php

namespace App\Controller;

use App\Entity\DescriptionUser;
use App\Form\DescriptionUserType;
use App\Form\UserType;
use App\Repository\DescriptionUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\DescriptionService;

class UserController extends AbstractController
{


    #[Route('/user', name: 'user')]
    public function user(
        DescriptionUserRepository $descriptionRepository,
        UserInterface $currentUser,
        DescriptionService $descriptionService,
        Request $request
    ): Response 
    {

        $formDescription = null; // Initialise la variable à null

        // Vérifie si la requête est une soumission de formulaire
        
            // Crée le formulaire seulement lorsqu'il est soumis
        $formDescription = $descriptionService->addDescription($currentUser);

        $descriptions = $descriptionRepository->findUserDescription($currentUser);

        return $this->render('user/user.html.twig', [
            'form' => $formDescription,
            'descriptions' => $descriptions,
        ]);
    }


    #[Route('/remove_description/{id}', name: 'remove-description')]
    public function removeFriend(int $id,
    Request $request,
    DescriptionUserRepository $descriptionRepository,
    EntityManagerInterface $em):Response
    {
        $currentUser = $this->getUser();

        if(!$currentUser){
            return $this->redirect($request->getUri());

        }

        $description = $descriptionRepository->find($id);

        if ($description) {
            $em->remove($description);
            $em->flush();
        }
        $referer = $request->server->get('HTTP_REFERER');
        return $referer ? $this->redirect($referer) : $this->redirect(('user'));
    }
    
}
