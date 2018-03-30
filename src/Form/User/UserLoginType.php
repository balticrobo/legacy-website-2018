<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\User;

use BalticRobo\Website\Model\User\UserLoginDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'user.form.user_login.username',
                'required' => true,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'user.form.user_login.password',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserLoginDTO::class,
        ]);
    }
}
