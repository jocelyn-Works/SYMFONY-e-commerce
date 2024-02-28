<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Product;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/product/like/{id}', name: 'app_like')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(
        Request $request,
        Product $product,
        EntityManagerInterface $em,
        LikeRepository $likeRepository
    ): Response {
        $user = $this->getUser();

        $like = $likeRepository->findOneBy([
            'product' => $product,
            'user' => $user
        ]) ?? null;

        if ($like) {

            $em->remove($like);
        } else {
            $like = new Like();
            $like->setUser($user)
                ->setProduct($product);

            $em->persist($like);
        }

        $em->flush();

        $referer = $request->server->get('HTTP_REFERER');
        return $referer ? $this->redirect($referer) : $this->redirect(('home'));
    }
}
