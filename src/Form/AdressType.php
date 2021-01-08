<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',  TextType::class,
            [
                'label' => "Nom : ",
                'attr' => [
                    "class" => "form-control"
                ]
            ])
            ->add('street' , TextType::class,
                [
                    'label' => "Votre rue : ",
                    'attr' => [
                        "class" => "form-control"
                    ]
                ])
            ->add('postal', NumberType::class,
                [
                    'html5' => true,
                    'label' => "Code Postal : ",
                    'attr' => [
                        "class" => "form-control",
                        'min' => 1000,
                        'max' => 97680
                    ]
                ])
            ->add('city', TextType::class,
                [
                    'label' => "Ville : ",
                    'attr' => [
                        "class" => "form-control"
                    ]
                ])
            ->add('country', TextType::class,
                [
                    'label' => "Pays : ",
                    'attr' => [
                        "class" => "form-control"
                    ]
                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
