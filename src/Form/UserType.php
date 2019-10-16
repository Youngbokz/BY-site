<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('log')
            ->add('password')
            // ->add('firstname')
            // ->add('lastname')
            // ->add('address')
            // ->add('city')
            // ->add('country')
            // ->add('email')
            // ->add('mobilePhone')
            // ->add('codeZip')
            // ->add('gender')
            // ->add('createdAt')
            // ->add('role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
