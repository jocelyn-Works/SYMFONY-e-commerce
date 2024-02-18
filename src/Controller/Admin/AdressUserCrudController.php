<?php

namespace App\Controller\Admin;

use App\Entity\AdressUser;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdressUserCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait; 

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return AdressUser::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Adress des Utilisateurs') //  nom de la table a afficher
            ->setEntityLabelInSingular('Ajouter une adress') // crée un utilisateur 
            ->setPageTitle("index", " Adress Utilisateurs") // titre page 
            ->setPaginatorPageSize(10); // 10 utilisateurs
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),

            AssociationField::new('author')
                // ->setFormTypeOption('disabled', 'disabled')
                ->setLabel('Auteur')
                ->formatValue(function ($value, $entity) {
                    return $entity->getAuthor()->getFullname();
                }),


            TextareaField::new('country')
                ->setLabel('Pays'),
            // ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('adress'),
            // ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('postalCode')
                ->setLabel('Code Postal'),
            // ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('city')
                ->setLabel('Ville'),
            // ->setFormTypeOption('disabled', 'disabled'),

            TextField::new('phone')
                ->setLabel('Télephone'),
            // ->setFormTypeOption('disabled', 'disabled'),



        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Appelé avant la mise à jour de l'entité dans la base de données
        if ($entityInstance instanceof AdressUser) {
            $entityInstance->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($entityInstance);
            $this->entityManager->flush();
        }
    }
}
