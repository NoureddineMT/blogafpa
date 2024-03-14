<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [ new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                    new Regex([
                    'pattern' => '/@/',
                    'message' => 'L\'adresse email doit contenir le caractère "@".'
                ]),
            ],
            ])
            ->add('name', TextType::class,[
                'attr' => ['placeholder' => 'Votre nom']
            ]
            )
            ->add('first_name')
            ->add('city')
            ->add('cp', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'exactMessage' => 'Le code postal doit contenir exactement 5 chiffres.',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions',
                    ]),
                ],
            ])
            ->add('password',  RepeatedType::class, [
                'type' =>PasswordType::class,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => [
                    'label' => 'Choisissez un mot de passe',
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
                        'message' => 'Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial.',
                    ]),]
                ],
                'second_options' => [
                    'label' => 'Répétez le nouveau mot de passe',
                   
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
               
            
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
