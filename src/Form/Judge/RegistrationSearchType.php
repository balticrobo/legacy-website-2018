<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Judge;

use BalticRobo\Website\Model\Judge\RegistrationSearchDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('teamNameOrIdentifier', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'team_name_or_identifier',
                ],
            ])
            ->add('memberSurname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'member_surname',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationSearchDTO::class,
        ]);
    }
}
