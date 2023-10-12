<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ["label" => "Nom du produit", "attr" => ['class' => "form-control mb-2", "placeholder" => "Nom du produit..."]])
            ->add('images', FileType::class, ["mapped" => false, "required" => false, "multiple" => true, "data_class" => null])
            ->add('price', TextType::class, ["label" => "Prix en DHs : ", "attr" => ['class' => "form-control mb-2 mt-2"]])
            ->add('stock', TextType::class, ["label" => "Quantité en stock : ", "attr" => ['class' => "form-control mb-2 mt-2"]])
            ->add('description', CKEditorType::class, ["label" => "Description et caracteristiques : "])
            ->add('Category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name', "label" => "Categorie : ", "attr" => ['class' => "form-control"]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
