<?php

namespace App\Form;

use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username or Email',
                'attr' => ['autofocus' => true],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Log In',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false, 
        ]);
    }
}

