<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Judge;

use BalticRobo\Website\Model\Judge\RegisterMemberDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('presence', CheckboxType::class, [
                'label' => false,
            ])
            ->add('shirtGivenOut', CheckboxType::class, [
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegisterMemberDTO::class,
        ]);
    }
}
