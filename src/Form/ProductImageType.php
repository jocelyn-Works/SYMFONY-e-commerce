<?php

namespace App\Form;

use App\Entity\product;
use App\Entity\ProductImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('picture', FileType::class,[
                'label' => 'Image de Profile :',
                'required' => $options['new_user'],
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => "Veuillez télécharger une image valide",
                        "maxSize" => '2M',
                        'maxSizeMessage' => "Votre image fait {{size}} {{suffix}}, La limite est de {{ limit }} {{suffix}}"
                        ]),
                    ]
                ])
            ->add('product', EntityType::class, [
                'class' => product::class,
                'choice_label' => 'id',
                ])
            // ->add('createdAt')
            // ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductImage::class,
        ]);
    }
}
