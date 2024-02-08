<?php

namespace App\Controller\Admin;

use App\Entity\AdressUser;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdressUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AdressUser::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Adress des Utilisateurs') //  nom de la table a afficher
        ->setEntityLabelInSingular('Ajouter une adress') // crée un utilisateur 
        ->setPageTitle("index", " E-commerce - Adress des Utilisateurs") // titre page 
        ->setPaginatorPageSize(10); // 10 utilisateurs
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            AssociationField::new('author')
                // ->setFormTypeOption('disabled', 'disabled')
                ->setLabel('Auteur')
                ->formatValue(function ($value, $entity) {
                    return $entity->getAuthor()->getFullname();
            }),

    
            TextareaField::new('country'),
            // ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('adress'),
            // ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('postalCode'),
            // ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('city'),
            // ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('phone'),
            // ->setFormTypeOption('disabled', 'disabled'),


            
        ];
    }
    
}
