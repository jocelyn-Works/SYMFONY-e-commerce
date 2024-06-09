<?php

namespace App\Form;

use App\Entity\Category;

use App\Entity\SubCategory;
use App\Entity\KindCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('kindCategory', EntityType::class, [
            'class' => KindCategory::class,
            'choice_label' => 'name',
            'label' => 'Catégorie Kind',
        ])
        ->add('subCategory', EntityType::class, [
            'class' => SubCategory::class,
            'choice_label' => 'name',
            'label' => 'Sous-catégorie',
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
