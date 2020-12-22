<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,
                [
                    'label' => "Votre Email : ",
                    'attr' => [
                        "class" => "form-control"
                    ]
                ])
            ->add('password' , RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        "label" => "Votre mot de passe: ",
                        'attr'=>[
                            "class"=>"form-control"
                        ]],
                    'second_options' => [
                        "label" => "Répétez votre mot de passe",

                        'attr'=>[
                            "class"=>"form-control"
                        ]
                    ]
                ])
            ->add('firstname', TextType::class,
                [
                    'label' => "Votre prenom : ",
                    'attr' => [
                        "class" => "form-control"
                    ]
                ])
            ->add('lastname', TextType::class,
                [
                    'label' => "Votre Nom : ",
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
            ->add('postal', TextType::class,
                [
                    'label' => "Code Postal : ",
                    'attr' => [
                        "class" => "form-control"
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
        if ($options['isAdmin']){
            $builder
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        "Admin"=> "ROLE_ADMIN",
                        "user" => "ROLE_USER"
                    ],
                    "multiple" => true,
                    "expanded" => true,
                    "label" => "Droits de l'utiliasteur",
                    'attr'=>[
                        "class"=>"form-control"
                    ]
                ]);}
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false
        ]);
    }
}
