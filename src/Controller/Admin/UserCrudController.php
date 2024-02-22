<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class UserCrudController extends AbstractCrudController
{
    use Trait\ReadOnlyTrait;


    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs') //  nom de la table a afficher
            ->setEntityLabelInSingular('Ajouter un Utilisateur') // crée un utilisateur 
            ->setPageTitle("index", "  Utilisateurs") // titre page 
            ->setPaginatorPageSize(10); // 10 utilisateurs
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),

            TextField::new('firstname')
                ->setLabel('Prénom'),

            TextField::new('lastname')
                ->setLabel('Nom'),

            EmailField::new('email')
                ->setLabel('Adress Email'),
            // ->setFormTypeOption('disabled', 'disabled') 

            DateTimeField::new('birthdate')
                ->setLabel('Anniversaire')
                ->setFormTypeOption('disabled', 'disabled'),

            ArrayField::new('roles')
                ->hideOnIndex(),

            TextField::new('password')
                ->hideOnIndex()
                ->hideOnForm(),

            IntegerField::new('condition_user')
            ->hideOnForm()
            ->hideOnIndex(),


            DateTimeField::new('updatedAt')
            ->hideOnForm(),

            AssociationField::new('AdressUsers')
                ->setLabel('Adress Utilisateurs')
                ->hideOnForm()
                ->formatValue(function ($value, $entity) {
                    // Supposons que la relation AdressUsers est de type many-to-one
                    $firstAddressUser = $entity->getAdressUsers()->first();

                    if ($firstAddressUser !== false && $firstAddressUser !== null) {
                        return $firstAddressUser->getAuthor();
                    }

                    return null;
                }),


        ];
    }
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Appelé avant la mise à jour de l'entité dans la base de données
        if ($entityInstance instanceof User) {
            $entityInstance->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($entityInstance);
            $this->entityManager->flush();
        }
    }
}
