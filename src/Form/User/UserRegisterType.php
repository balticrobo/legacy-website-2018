<?php declare(strict_types=1);

namespace BalticRobo\Website\Form\User;

use BalticRobo\Website\Model\User\UserRegisterDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'user.form.email',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'user_register.password.mismatch',
                'first_options' => [
                    'label' => 'user.form.password',
                ],
                'second_options' => [
                    'label' => 'user.form.password_repeat',
                ],
            ])
            ->add('forename', TextType::class, [
                'label' => 'user.form.forename',
            ])
            ->add('surname', TextType::class, [
                'label' => 'user.form.surname',
            ])
            ->add('newsletterAndMarketing', CheckboxType::class, [
                'label' => 'user.form.newsletter_and_marketing',
            ])
            ->add('terms', CheckboxType::class, [
                'label' => 'user.form.terms',
            ])
            ->add('gdpr', CheckboxType::class, [
                'label' => 'user.form.gdpr',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserRegisterDTO::class,
        ]);
    }
}
