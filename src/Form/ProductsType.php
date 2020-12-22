<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                [
                    'label' => "Titre : ",
                    'attr' => [
                        "class" => "form-control"
                    ]
                ])
            ->add('description', TextareaType::class,
                [
                    'label' => "Description : ",
                    'attr' => [
                        "class" => "form-control"
                    ]
                ])
            ->add('type', EntityType::class,
                [
                    'class' => Type::class,
                    'expanded' => true,
                    'multiple' => false,
                    'label' => "Choisissez un type de produit: ",
                    'label_attr' => [
                        "class" => "my-2"
                    ],
                    "choice_attr"=>function(){
                        return ["class"=>"form-check-input"];
                    }

                ])
            ->add('price', MoneyType::class,
                [
                    'label' => "Prix:",
                    'currency' => false,
                    'attr' => [
                        "class" => "form-control"
                    ]
                ])
            ->add('imageFile' , VichImageType::class, [
                "required" => true,
                'attr' => [
                    "class" => "form-control"
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
