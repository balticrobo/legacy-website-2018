<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Registration\Hackathon;

use BalticRobo\Website\Adapter\DoctrineEnum\ShirtTypeEnum;
use BalticRobo\Website\Model\Registration\Hackathon\AddMemberDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $teamHaveCaptain = $options['team_have_captain'];
        $builder
            ->add('forename', TextType::class, [
                'label' => 'competitor_zone.registration.form.forename',
            ])
            ->add('surname', TextType::class, [
                'label' => 'competitor_zone.registration.form.surname',
            ])
            ->add('age', NumberType::class, [
                'label' => 'competitor_zone.registration.form.age',
            ])
            ->add('shirtType', ChoiceType::class, [
                'label' => 'competitor_zone.registration.form.shirt_type',
                'choices' => ShirtTypeEnum::getFormData(),
            ])
            ->add('captain', CheckboxType::class, [
                'label' => 'competitor_zone.registration.form.is_captain',
                'disabled' => $teamHaveCaptain,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddMemberDTO::class,
        ]);
        $resolver->setRequired('team_have_captain');
        $resolver->setAllowedTypes('team_have_captain', 'bool');
    }
}
