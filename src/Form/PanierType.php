<?php

namespace App\Form;

use App\Entity\Panier;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount')
            // ->add('date', null, [
            //     'widget' => 'single_text'
            // ])
            ->add('state')
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            // 'choice_label' => 'id',
            // ])
            ->add('name')
            ->add('description')
            ->add('quantity')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Panier::class,
        ]);
    }
}
