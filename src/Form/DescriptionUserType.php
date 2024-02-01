<?php

namespace App\Form;

use DateTime;
use App\Entity\User;
use App\Entity\DescriptionUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class DescriptionUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('country', CountryType::class,[
                'label' => 'Pays'
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse :'
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code Postale :'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville :'
            ])
            ->add('phone', TextType::class,[
                'label' => 'Numéros de téléphone'
            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => 'Date d\'anniversaire :'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DescriptionUser::class,
        ]);
    }
}
