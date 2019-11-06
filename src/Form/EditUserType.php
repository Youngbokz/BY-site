<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('country')
            ->add('email')
            ->add('mobilePhone')
            ->add('codeZip')
            ->add('gender')
<<<<<<< HEAD
        ;
=======
            ;
>>>>>>> e4a5899124068916b5a27123b86ab068878c490f
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
