<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname',TextType::class,[
                'label' => 'Nom'
            ])
            ->add('firstname',TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class,[
                'label' => 'Adress Email :'
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe'
            ])
            ->add('birthdate', DateType::class,[
                'label' => 'Date de Naissance'
            ])
            ->add('condition_user', CheckboxType::class,[
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            
        ]);
    }
}
