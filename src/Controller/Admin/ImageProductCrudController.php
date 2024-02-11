<?php

namespace App\Controller\Admin;

use App\Entity\ImageProduct;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImageProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ImageProduct::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),

            TextField::new('name'),
            
            TextEditorField::new('size'),
        ];
    }

}
