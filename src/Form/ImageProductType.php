<?php

namespace App\Form;

use App\Entity\product;
use App\Entity\ImageProduct;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ImageProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('file', VichImageType::class, [
            // 'required' => false,
            // 'allow_delete' => true,
            // 'delete_label' => '...',
            // 'download_label' => '...',
            // 'download_uri' => true,
            // 'image_uri' => true,
            // 'imagine_pattern' => '...',
            // 'asset_helper' => true,
        ]);
            
            // ->add('createdAt')
            // ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImageProduct::class,
        ]);
    }
}
