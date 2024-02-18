<?php

namespace App\Controller\Admin;

use App\Entity\ImageProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImageProductCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait; 

    public static function getEntityFqcn(): string
    {
        return ImageProduct::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Images') //  nom de la table a afficher
            ->setEntityLabelInSingular('Images') // crée un utilisateur 
            ->setPageTitle("index", "Images") // titre page 
            ->setPaginatorPageSize(10); // 10 utilisateurs
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            AssociationField::new('product')
            ->setLabel('Produit'),
            
            ImageField::new('name')
            ->setLabel('Image')
            ->setBasePath('/uploads/products')
            ->setUploadDir('/public/uploads/products'),
            
            NumberField::new('size')
            ->setLabel('Taille Image'),
            
            IdField::new('id'),
        ];
    }

}
