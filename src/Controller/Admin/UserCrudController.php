<?php

namespace App\Controller\Admin;


use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs') //  nom de la table a afficher
            ->setEntityLabelInSingular('Ajouter un Utilisateur') // crée un utilisateur 
            ->setPageTitle("index", " E-commerce - Administration Utilisateurs") // titre page 
            ->setPaginatorPageSize(10); // 10 utilisateurs
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('firstname'),

            TextField::new('lastname'),

            EmailField::new('email'),
            // ->setFormTypeOption('disabled', 'disabled') 

            ArrayField::new('roles')
                ->hideOnIndex(),

            DateTimeField::new('createdAt'),
            // ->setFormTypeOption('disabled', 'disabled'),

            AssociationField::new('AdressUsers')
                ->setLabel('Adress Utilisateurs')
                ->hideOnForm(),
            
        ];
    }

}
