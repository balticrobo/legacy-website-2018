<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Judge;

use BalticRobo\Website\Model\Judge\RegisterTeamDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterTeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('members', CollectionType::class, [
                'label' => false,
                'entry_type' => RegisterMemberType::class,
            ])
            ->add('constructions', CollectionType::class, [
                'label' => false,
                'entry_type' => RegisterConstructionType::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegisterTeamDTO::class,
        ]);
    }
}
