<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Cms;

use BalticRobo\Website\Adapter\DoctrineEnum\PartnerTypeEnum;
use BalticRobo\Website\Model\Cms\AddPartnerDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Partner name',
                'attr' => [
                    'placeholder' => 'Acme Corp',
                ],
            ])
            ->add('url', TextType::class, [
                'label' => 'Partner url (full)',
                'attr' => [
                    'placeholder' => 'https://acme.com',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Partner type',
                'choices' => PartnerTypeEnum::getFormData(),
            ])
            ->add('sortOrder', NumberType::class, [
                'label' => 'Sort order (higher means more important)',
                'data' => 0,
            ])
            ->add('file', AddFileWithoutDescriptionType::class, [
                'label' => 'Logo',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddPartnerDTO::class,
        ]);
    }
}
