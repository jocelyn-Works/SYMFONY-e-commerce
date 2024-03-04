<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use DateTimeImmutable;
use App\Entity\AdressUser;
use App\Form\AdressUserType;
use App\Repository\AdressUserRepository;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
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

// information de l'utilisateur 
    #[Route('/user', name: 'user')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function user(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        /**
         * @var User
         */
        $user = $this->getUser();

        $userForm = $this->createForm(UserType::class, $user);
        $userForm->remove('password')
            ->remove('condition_user');

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $em->flush();
        }

        return $this->render('user/index.html.twig', [
            'form' => $userForm->createView()
        ]);
    }

// adress de l'utilisateurs
    #[Route('/adress', name: 'user_adress')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function user_adress(
        AdressUserRepository $AdressUserRepository,
        UserInterface $currentUser
    ): Response {

        $adress = $AdressUserRepository->findUserAdress($currentUser);

        return $this->render('user/user_adress.html.twig', [
            'adresss' => $adress,
        ]);
    }

    // ajouter une adress
    #[Route('/add_adress', name: 'user_add_adress')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add_user_adress(
        Request $request,
        EntityManagerInterface $em,
        UserInterface $user,
        AdressUserRepository $AdressUserRepository,
        UserInterface $currentUser,
    ): Response {

        $newAdresss = new AdressUser();

        $addAdressForm = $this->createForm(AdressUserType::class, $newAdresss);


        $addAdressForm->handleRequest($request);

        if ($addAdressForm->isSubmitted() && $addAdressForm->isValid()) {

            $newAdresss->setAuthor($user);


            $em->persist($newAdresss);
            $em->flush();

            return $this->redirectToRoute('user_adress');
        }

        $adress = $AdressUserRepository->findUserAdress($currentUser);

        return $this->render('user/add_user_adress.html.twig', [
            'form' => $addAdressForm->createView(),
            'adresss' => $adress,
        ]);
    }

    // suprimer une adress
    #[Route('/remove_adress/{id}', name: 'remove_adress')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function removeFriend(
        int $id,
        Request $request,
        AdressUserRepository $AdressUserRepository,
        EntityManagerInterface $em
    ): Response {
        $currentUser = $this->getUser();

        if (!$currentUser) {
            return $this->redirect($request->getUri());
        }

        $adress = $AdressUserRepository->find($id);

        if ($adress) {
            $em->remove($adress);
            $em->flush();
        }
        $referer = $request->server->get('HTTP_REFERER');
        return $referer ? $this->redirect($referer) : $this->redirect(('user'));
    }

    // modifier une adress
    #[Route('/edit_adress/{id}', name: 'edit_adress')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editDescription(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        AdressUserRepository $AdressUserRepository
    ): Response {
        /**
         * @var User
         */
        $currentUser = $this->getUser();

        if (!$currentUser) {
            return $this->redirect($request->getUri());
        }

        $adress = $AdressUserRepository->find($id);

        $formAdress = $this->createForm(AdressUserType::class, $adress);

        $formAdress->handleRequest($request);
        if ($formAdress->isSubmitted() && $formAdress->isValid()) {

            $adress->setUpdatedAt(new DateTimeImmutable());

            $em->flush();

            return $this->redirectToRoute('user_adress');
        }
        $adress = $AdressUserRepository->findUserAdress($currentUser);

        return $this->render('user/updateDescription.html.twig', [
            'form' => $formAdress,
            'adresss' => $adress
        ]);
    }


// commande de l'utilisateur
    #[Route('/commande', name: 'user_commande')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function user_commande(): Response
    {


        return $this->render('user/userCommande.html.twig', []);
    }

 // favoris utilisateurs
    #[Route('/favorite', name: 'user_favorite')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function favorite(UserInterface $currentUser,
    LikeRepository $likeRepository): Response
    {

        $likes = $likeRepository->findUserLikes($currentUser);


        return $this->render('user/userLikes.html.twig', [
            'likes' => $likes
        ]);
    }




    // changer le mot de passe
    #[Route('/change_password', name: 'changePassword')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function changePassword(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {

        /**
         * @var User
         */
        $user = $this->getUser();

        $passwordForm = $this->createFormBuilder()
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrez deux mot de passe Identique']),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Veuillez entrez plus de 5 catactéres'
                    ])
                ],
                'invalid_message' => 'Les champs des mots de passe doivent correspondre.',
                'required' => false,
                'first_options'  => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmer le nouveau mot de passe'],
            ])
            ->getForm();

        $passwordForm->handleRequest($request);
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {

            $newPassword = $passwordForm->get('newPassword')->getData();

            if ($newPassword) {
                $hash = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hash);
            }

            $user->setUpdatedAt(new DateTimeImmutable());
            $em->flush();

            return $this->redirectToRoute('user');
        }
        return $this->render('user/changePassword.html.twig', [
            'form' => $passwordForm->createView(),
        ]);
    }
}
