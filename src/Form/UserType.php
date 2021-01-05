<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
                        ],
                    ],
                    'second_options' => [
                        "label" => "Répétez votre mot de passe",

                        'attr'=>[
                            "class"=>"form-control"
                        ],
                    ],
                    'invalid_message' => 'Les deux mots de passe sont differents',


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
        if ($options['isAdmin']){
            $builder
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        "Admin"=> "ROLE_ADMIN",
                        "user" => "ROLE_USER"
                    ],
                    "multiple" => true,
                    "expanded" => true,
                    "label" => "Droits de l'utilisateur : ",
                    'attr'=>[
                        "class"=>"form-control"
                    ],
                    "choice_attr"=>function(){
                        return ["class"=>"form-check-input mx-1"];}
                ]);}
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false,


        ]);
    }
}
