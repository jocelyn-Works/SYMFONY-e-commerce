<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ImageProductType;
use Doctrine\ORM\EntityManagerInterface;
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

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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

            CollectionField::new('images')
                ->setLabel('image')
                ->setEntryType(ImageProductType::class),

            DateTimeField::new('createdAt')
                ->hideOnForm(),

            DateTimeField::new('updatedAt')
                ->hideOnForm(),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Appelé avant la mise à jour de l'entité dans la base de données
        if ($entityInstance instanceof Product) {
            $entityInstance->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($entityInstance);
            $this->entityManager->flush();
        }
    }
}
