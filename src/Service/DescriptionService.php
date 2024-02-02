<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\DescriptionUser;
use App\Form\DescriptionUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\FormFactoryInterface;

class DescriptionService
{
    private $entityManager;
    private $formFactory;
    private $requestStack;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
    }

    public function addDescription(UserInterface $user)
    {
        $newDescription = new DescriptionUser();

        $userForm = $this->formFactory->create(DescriptionUserType::class, $newDescription);

        $userForm->handleRequest($this->requestStack->getCurrentRequest());

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $newDescription->setAuthor($user);

            $entityManager = $this->entityManager;
            $entityManager->persist($newDescription);
            $entityManager->flush();

        }
        return $userForm->createView();
    }
}
?>