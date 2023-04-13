<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SearchProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searched', TextType::class,['mapped' => false,'label' => false, 'attr' => ['class' => 'form-control mb-4 mr-2','placeholder' => 'Chercher un produit']])
            ->add('Chercher', SubmitType::class, [
                'attr' => ['class' => 'btn btn-secondary my-2 my-sm-0 ml-2'],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
