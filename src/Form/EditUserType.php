<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            //->add('password')
            ->add('firstname')
            ->add('lastname')
            ->add('address')
            ->add('city')
            ->add('country', ChoiceType::class, [
                'choices' => ['France' => 'France',
                'Allemagne' => 'Allemagne',
                'États-Unis' => 'États-Unis',
                'Royaume-Unis' => 'Royaume-Unis',
                'Italie' => 'Italie',
                'Espagne' => 'Espagne',
                'Autres' => 'Autres'],
            ])
            ->add('email')
            ->add('mobilePhone')
            ->add('codeZip')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Homme' => true,
                    'Femme' => false,
                    'Autre' => null,
                ],
                'choice_label' => function($choice, $key, $value){
                    if(true === $choice){
                        return "Homme";
                    }
                    elseif(false === $choice){
                        return "Femme";
                    }
                    else{
                        return "Autre";
                    }
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
