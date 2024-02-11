<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs') //  nom de la table a afficher
            ->setEntityLabelInSingular('Ajouter un produit')       // crée un produit
            ->setPageTitle("index", " E-commerce - Administration Produit") // titre page 
            ->setPaginatorPageSize(10); // 10 utilisateurs
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('name'),

            TextareaField::new('description'),

            MoneyField::new('price')->setCurrency('EUR'),

            ImageField::new('productImages')
                ->setBasePath('uploads/images') // Chemin vers le répertoire des images
                ->setUploadDir('public/uploads/') // Répertoire d'upload des images
                ->setLabel('Product Images')
                ->onlyOnForms(),

            DateTimeField::new('createdAt')
                ->hideOnForm(),

            DateTimeField::new('updatedAt')
                ->hideOnForm(),
        ];
    }
}
