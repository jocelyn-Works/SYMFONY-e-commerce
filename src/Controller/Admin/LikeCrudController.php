<?php

namespace App\Controller\Admin;

use App\Entity\Like;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class LikeCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait;


    public static function getEntityFqcn(): string
    {
        return Like::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Favoris des Utilisateurs') //  nom de la table a afficher
            ->setEntityLabelInSingular('Ajouter une favoris') // crée un utilisateur 
            ->setPageTitle("index", " Favoris Utilisateurs") // titre page 
            ->setPaginatorPageSize(10); // 10 utilisateurs
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),

            AssociationField::new('user')
                ->setLabel('Utilisateurs')
                ->formatValue(function ($value, $entity) {
                    return $entity->getUser()->getFullname();
                }),

            AssociationField::new('product'),

        ];
    }
}
