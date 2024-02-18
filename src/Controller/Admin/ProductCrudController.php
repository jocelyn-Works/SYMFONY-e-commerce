<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ImageProductType;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class ProductCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait;


    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Produits') //  nom de la table a afficher

            ->setEntityLabelInSingular('Ajouter un produit')       // crée un produit

            ->setPageTitle("index", "Produit") // titre page 

            ->setPaginatorPageSize(10); // 10 utilisateurs


    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('name')
                ->setLabel('Produit'),

            TextareaField::new('description')
                ->setLabel('Description'),

            MoneyField::new('price')
                ->setCurrency('EUR')
                ->setStoredAsCents()
                ->setLabel('Prix'),

            CollectionField::new('categories')
                ->setLabel('categorie')
                ->setEntryType(CategoryType::class),

            CollectionField::new('images')
                ->setLabel('image')
                ->hideOnIndex()
                ->setEntryType(ImageProductType::class),

            DateTimeField::new('createdAt')
                ->hideOnForm(),

            DateTimeField::new('updatedAt')
                ->hideOnForm(),
        ];
    }
}
