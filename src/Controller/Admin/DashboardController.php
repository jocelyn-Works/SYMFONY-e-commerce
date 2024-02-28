<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\AdressUser;
use App\Entity\Gender;
use App\Entity\ImageProduct;
use App\Entity\KindCategory;
use App\Entity\Size;
use App\Entity\Stock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use App\Entity\SubCategory;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration')
            // ->setTitle('<img src=""> ACME <span class="text-small">Corp.</span>')

            ->renderSidebarMinimized()

            ->setLocales(['fr'])
            ->setLocales([
                'en' => '🇬🇧 English',
                'fr' => '🇫🇷 Français'
            ])


            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::section('Blog');
        yield MenuItem::linkToRoute('Retour au Site', 'fa fa-undo', 'home');
        // yield MenuItem::linkToLogout('Logout', 'fa fa-exit');

        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::subMenu('Utilisateurs', icon: 'fas fa-users',)->setSubItems([
            MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class),
            MenuItem::linkToCrud('Adress-Utilisateurs', 'fas fa-address-book', AdressUser::class),

        ]);


        yield MenuItem::subMenu('Produits', 'fas fa-gear',)->setSubItems([
            MenuItem::linkToCrud('Produits', 'fas fa-shirt', Product::class),
            MenuItem::linkToCrud('Images Produits', 'fas fa-image', ImageProduct::class),
            MenuItem::linkToCrud('Stock Produits', 'fas fa-note-sticky', Stock::class),
            MenuItem::linkToCrud('categorie', 'fas fa-plus', KindCategory::class),
            MenuItem::linkToCrud('Sous categorie', 'fas fa-plus', SubCategory::class),
            MenuItem::linkToCrud('Taille', 'fab fa-delicious', Size::class),
            MenuItem::linkToCrud('Genre', 'fas fa-venus-mars', Gender::class),

        ]);
        
    }
}
