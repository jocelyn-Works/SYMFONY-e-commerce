<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
use App\Form\SizeType;
use App\Form\GenderType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StockCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait;

    public static function getEntityFqcn(): string
    {
        return Stock::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Stock produits') //  nom de la table a afficher
            ->setEntityLabelInSingular('Ajouter un Stock') // crée un utilisateur 
            ->setPageTitle("index", "  Stocks") // titre page 
            ->setPaginatorPageSize(10); // 10 utilisateurs
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),

            AssociationField::new('product')

                ->setLabel('Produit')
                ->formatValue(function ($value, $entity) {
                    return $entity->getProduct()->getName();
                }),

            AssociationField::new('gender')
                ->setLabel('Genre'),
    
            AssociationField::new('size')
                ->setLabel('Taille'),     
                
            TextField::new('quantity')  
            ->setLabel('Quantiter :'),




        ];
    }
}
