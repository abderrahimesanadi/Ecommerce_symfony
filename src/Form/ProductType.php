<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ["label" => "Nom du produit", "attr" => ['class' => "form-control mb-2", "placeholder" => "Nom du produit..."]])
            ->add('image', FileType::class, [/*"multiple" => true,*/"data_class" => null, "attr" => ['class' => "form-control mb-2"]])
            ->add('price', TextType::class, ["label" => "Prix en DHs : ", "attr" => ['class' => "form-control mb-2 mt-2"]])
            ->add('quantity', TextType::class, ["label" => "Quantité en stock : ", "attr" => ['class' => "form-control mb-2 mt-2"]])
            ->add('description', TextareaType::class, ["label" => "Description et caracteristiques : ", "attr" => ['class' => "form-control mb-2 mt-2", 'rows' => 12]])
            ->add('Category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name', "label" => "Categorie : ", "attr" => ['class' => "form-control"]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
