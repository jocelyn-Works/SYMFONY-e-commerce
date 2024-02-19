<?php

namespace App\Controller\Admin;

use App\Entity\Gender;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GenderCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait; 

    public static function getEntityFqcn(): string
    {
        return Gender::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Genre') //  nom de la table a afficher

            ->setEntityLabelInSingular('Ajouter un Genre')       // crée un produit

            ->setPageTitle("index", "Genre") // titre page 

            ->setPaginatorPageSize(10); // 10 utilisateurs
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
