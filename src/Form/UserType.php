<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add('roles')
            // ->add('password')
            // ->add('isVerified')
            ->add('avatar', FileType::class, [
                'label' => 'Picture (JPEG, PNG, GIF)',
                // Ajoutez d'autres contraintes de validation si nécessaire
                'mapped' => false, // Indique que ce champ ne correspond pas directement à une propriété de l'entité
                'required' => false, // Le champ n'est pas obligatoire
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un png ou un jpeg',
                    ])
                    ],
            ])
            ->add('name')
            ->add('first_name')
            ->add('city')
            ->add('cp')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
