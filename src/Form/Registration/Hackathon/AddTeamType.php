<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Registration\Hackathon;

use BalticRobo\Website\Model\Registration\Hackathon\AddTeamDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('city', TextType::class, [
                'label' => 'competitor_zone.registration.form.city',
            ])
            ->add('whyYou', TextareaType::class, [
                'label' => 'competitor_zone.registration.form.why_you',
                'attr' => [
                    'rows' => 7,
                ],
            ])
            ->add('experience', TextareaType::class, [
                'label' => 'competitor_zone.registration.form.experience',
                'attr' => [
                    'rows' => 7,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddTeamDTO::class,
        ]);
    }
}
