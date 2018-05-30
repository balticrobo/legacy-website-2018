<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Registration\Hackathon;

use BalticRobo\Website\Adapter\DoctrineEnum\RegistrationTypeEnum;
use BalticRobo\Website\Model\Registration\SurveyDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $params = ['label_format' => 'competitor_zone.survey.form.%name%'];

        $builder
            ->add('sample_question', TextareaType::class, $params)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SurveyDTO::class,
            'empty_data' => function (FormInterface $form) {
                return new SurveyDTO([
                    'sample_question' => $form->get('sample_question')->getData(),
                ], RegistrationTypeEnum::HACKATHON);
            },
        ]);
    }
}
