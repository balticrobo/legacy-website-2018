<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Registration\Competition;

use BalticRobo\Website\Model\Registration\Competition\AddTeamDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddTeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'competitor_zone.registration.form.name',
            ])
            ->add('identifier', TextType::class, [
                'label' => 'competitor_zone.registration.form.identifier',
            ])
            ->add('city', TextType::class, [
                'label' => 'competitor_zone.registration.form.city',
            ])
            ->add('scientificOrganization', TextType::class, [
                'label' => 'competitor_zone.registration.form.scientific_organization',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddTeamDTO::class,
        ]);
    }
}
