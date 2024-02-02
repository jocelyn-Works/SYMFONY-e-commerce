<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\DescriptionUser;
use App\Repository\UserRepository;
use App\Service\DescriptionService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DescriptionUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{


    #[Route('/user', name: 'user')]
    public function user(
        DescriptionUserRepository $descriptionRepository,
        UserInterface $currentUser,
        DescriptionService $descriptionService,
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

    #[Route('/edit_description/{id}', name: 'edit-description')]
    public function editDescription(int $id, Request $request,
    EntityManagerInterface $em,
    DescriptionUserRepository $descriptionRepository,
    DescriptionService $descriptionService): Response
    {
        $currentUser = $this->getUser();

        if (!$currentUser) {
            return $this->redirect($request->getUri());
        }

        $description = $em->getRepository(DescriptionUser::class)->find($id);

        if (!$description) {
            // Gérer le cas où la description n'est pas trouvée, par exemple rediriger ou afficher une erreur
        }

        $formDescription = $descriptionService->addDescription($currentUser);
        $descriptions = $descriptionRepository->findUserDescription($currentUser);

        return $this->render('user/user.html.twig', [
            'form' => $formDescription,
            'descriptions' => $descriptions
        ]);
    }






    #[Route('/user/change-password', name: 'changePassword')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function changePassword(Request $request,
     EntityManagerInterface $em,
     UserPasswordHasherInterface $passwordHasher,
     ): Response
    {
        
         /**
         * @var User
         */
        $user =$this->getUser();
        
        $passwordForm = $this->createFormBuilder()
                         ->add('newPassword' , RepeatedType::class, [
                            'type' => PasswordType::class,
                            'constraints' => [
                                new NotBlank(['message' => 'Veuillez entrez deux mot de passe Identique']),
                                new Length([
                                    'min' => 5,
                                    'minMessage' => 'Veuillez entrez plus de 5 catactéres'])
                                ],
                            'invalid_message' => 'Les champs des mots de passe doivent correspondre.',
                            'required' => false,
                            'first_options'  => ['label' => 'Nouveau mot de passe'],
                            'second_options' => ['label' => 'Confirmer le nouveau mot de passe'],
                        ])
                        ->getForm();
        
        $passwordForm->handleRequest($request);
        if($passwordForm->isSubmitted() && $passwordForm->isValid()){
            $newPassword = $passwordForm->get('newPassword')->getData();
            
            if ($newPassword) {
                $hash = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hash);
            }
            $em->flush();

            return $this->redirectToRoute('user');
            
        }
        return $this->render('user/changePassword.html.twig', [
            'form' => $passwordForm->createView(),
             


        ]);
    }
    
}
