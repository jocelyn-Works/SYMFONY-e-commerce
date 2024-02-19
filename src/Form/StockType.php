<?php

namespace App\Form;

use App\Entity\Size;

use App\Entity\Stock;
use App\Entity\Gender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig\EntityListeners\EntityConfig;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'label' => 'Genre :',
                'choice_label' => 'name',
            ])

            ->add('size', EntityType::class, [
                'class' => Size::class,
                'label' => 'Taille :',
                'choice_label' => 'name',
            ])

            ->add('quantity', TextType::class, [
                'label' => 'Quantiter :',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
