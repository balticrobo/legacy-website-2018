<?php declare(strict_types=1);

namespace BalticRobo\Website\Form\User;

use BalticRobo\Website\Model\User\UserPasswordDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'user_reset_password.password.mismatch',
                'first_options' => [
                    'label' => 'user.form.password',
                ],
                'second_options' => [
                    'label' => 'user.form.password_repeat',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserPasswordDTO::class,
        ]);
    }
}
