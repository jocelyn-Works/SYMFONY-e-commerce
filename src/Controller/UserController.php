<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\DescriptionUser;
use App\Form\DescriptionUserType;
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
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function user(
    
    ): Response 
    {


        return $this->render('user/index.html.twig', [
            
        ]);
    }

    // ajouter une adress
    #[Route('/user/adress', name: 'user_adress')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function user_adress(
        DescriptionUserRepository $descriptionRepository,
        UserInterface $currentUser
    ): Response 
    {

        $descriptions = $descriptionRepository->findUserDescription($currentUser);

        return $this->render('user/user_adress.html.twig', [
            'descriptions' => $descriptions,
        ]);
    }

    #[Route('/user/add_adress', name: 'user_add_adress')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add_user_adress(
        Request $request,
        EntityManagerInterface $em,
        UserInterface $user,
        DescriptionUserRepository $descriptionRepository,
        UserInterface $currentUser,
    ): Response 
    {

        $newDescription = new DescriptionUser();

        $addDescriptionForm = $this->createForm(DescriptionUserType::class, $newDescription);
        

        $addDescriptionForm->handleRequest($request);

        if ($addDescriptionForm->isSubmitted() && $addDescriptionForm->isValid()) {

            $newDescription->setAuthor($user);

            
            $em->persist($newDescription);
            $em->flush();

            return $this->redirectToRoute('user_adress');

        }

        $descriptions = $descriptionRepository->findUserDescription($currentUser);

        return $this->render('user/add_user_adress.html.twig', [
            'form' => $addDescriptionForm->createView(),
            'descriptions' => $descriptions,
        ]);
    }

// suprimer une adress
    #[Route('/user/remove_description/{id}', name: 'remove-description')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
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

// modifier une adress
    #[Route('/user/edit_description/{id}', name: 'edit-description')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editDescription(int $id, Request $request,
    EntityManagerInterface $em,
    DescriptionUserRepository $descriptionRepository): Response
    {
         /**
         * @var User
         */
        $currentUser = $this->getUser();

        if(!$currentUser){
            return $this->redirect($request->getUri());

        }

        $description = $descriptionRepository->find($id);

        $formDescription =$this->createForm(DescriptionUserType::class, $description);
        
        $formDescription->handleRequest($request);
        if($formDescription->isSubmitted() && $formDescription->isValid()){

        $em->flush();

        return $this->redirectToRoute('user_adress');

        }
        $descriptions = $descriptionRepository->findUserDescription($currentUser);

        return $this->render('user/updateDescription.html.twig', [
            'form' => $formDescription,
            'descriptions' => $descriptions
        ]);
    }


// changer le mot de passe
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
