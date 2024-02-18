<?php

namespace App\Controller\Admin;

use App\Entity\KindCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class KindCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return KindCategory::class;

        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Categorie') //  nom de la table a afficher
            ->setEntityLabelInSingular('Ajouter une Categrie') // crée un utilisateur 
            ->setPageTitle("index", "Categorie") // titre page 
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
