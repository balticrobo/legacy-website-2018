<?php declare(strict_types=1);

namespace BalticRobo\Website\Form\Registration\Hackathon;

use BalticRobo\Website\Adapter\Enum\RegistrationTypeEnum;
use BalticRobo\Website\Model\Registration\SurveyDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $params = ['label_format' => 'survey.form.%name%', 'mapped' => false];

        $builder
            ->add(
                'scale_robohackathon',
                ChoiceType::class,
                array_merge($params, $this->choiceSimpleScale())
            )
            ->add(
                'scale_robohackathon_comfort_in_room',
                ChoiceType::class,
                array_merge($params, $this->choiceScale())
            )
            ->add(
                'scale_robohackathon_comfort_in_workshop',
                ChoiceType::class,
                array_merge($params, $this->choiceScale())
            )
            ->add('any_complains_about_location', TextareaType::class, array_merge($params, [
                'constraints' => [
                    new NotBlank(['message' => 'survey.text.not_blank']),
                    new Length(['min' => 3, 'minMessage' => 'survey.text.length.min']),
                ],
            ]))
            ->add('robohackathon_missing_tools_and_materials', TextareaType::class, array_merge($params, [
                'constraints' => [
                    new NotBlank(['message' => 'survey.text.not_blank']),
                ],
            ]))
            ->add('robohackathon_food_was_good', ChoiceType::class, array_merge($params, $this->choiceYesNo()))
            ->add('robohackathon_time', ChoiceType::class, array_merge($params, $this->choiceTime()))
            ->add('robohackathon_volunteers', ChoiceType::class, array_merge($params, $this->choiceSimpleScale()))
            ->add('robohackathon_final_battle', ChoiceType::class, array_merge($params, $this->choiceYesNo()))
            ->add('how_did_you_know_about_event', TextType::class, array_merge($params, [
                'constraints' => [
                    new NotBlank(['message' => 'survey.text.not_blank']),
                    new Length(['min' => 3, 'minMessage' => 'survey.text.length.min']),
                ],
            ]))
            ->add(
                'robohackathon_will_you_come_next_year',
                ChoiceType::class,
                array_merge($params, $this->choiceYesNo())
            )
            ->add('notes', TextareaType::class, $params)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SurveyDTO::class,
            'empty_data' => function (FormInterface $form) {
                return new SurveyDTO([
                    'scale_robohackathon' => $form->get('scale_robohackathon')->getData(),
                    'scale_robohackathon_comfort_in_room' => $form->get('scale_robohackathon_comfort_in_room')
                        ->getData(),
                    'scale_robohackathon_comfort_in_workshop' => $form->get('scale_robohackathon_comfort_in_workshop')
                        ->getData(),
                    'any_complains_about_location' => $form->get('any_complains_about_location')->getData(),
                    'robohackathon_missing_tools_and_materials' => $form
                        ->get('robohackathon_missing_tools_and_materials')->getData(),
                    'robohackathon_food_was_good' => $form->get('robohackathon_food_was_good')
                        ->getData(),
                    'robohackathon_time' => $form->get('robohackathon_time')->getData(),
                    'robohackathon_volunteers' => $form->get('robohackathon_volunteers')->getData(),
                    'robohackathon_final_battle' => $form->get('robohackathon_final_battle')->getData(),
                    'how_did_you_know_about_event' => $form->get('how_did_you_know_about_event')->getData(),
                    'robohackathon_will_you_come_next_year' => $form->get('robohackathon_will_you_come_next_year')
                        ->getData(),
                    'notes' => $form->get('notes')->getData(),
                ], RegistrationTypeEnum::HACKATHON);
            },
        ]);
    }

    private function choiceYesNo(): array
    {
        return [
            'choices' => [
                'survey.form.yes_no.yes' => 'yes',
                'survey.form.yes_no.no' => 'no',
            ],
            'expanded' => true,
            'multiple' => false,
            'constraints' => [
                new NotBlank(['message' => 'survey.yes_no.not_blank']),
            ],
        ];
    }

    private function choiceTime(): array
    {
        return [
            'choices' => [
                'survey.form.time.too_short' => 'too_short',
                'survey.form.time.enough' => 'enough',
                'survey.form.time.too_long' => 'too_long',
            ],
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'survey.form.choice.placeholder',
            'constraints' => [
                new NotBlank(['message' => 'survey.time.not_blank']),
            ],
        ];
    }

    private function choiceScale(): array
    {
        return [
            'choices' => [
                'survey.form.choice.very_weak' => 'very_weak (1/9)',
                'survey.form.choice.weak' => 'weak (2/9)',
                'survey.form.choice.more_or_less' => 'more_or_less (3/9)',
                'survey.form.choice.rather' => 'rather (4/9)',
                'survey.form.choice.could_be_better' => 'could_be_better (5/9)',
                'survey.form.choice.its_ok' => 'its_ok (6/9)',
                'survey.form.choice.very_good' => 'very_good (7/9)',
                'survey.form.choice.great' => 'great (8/9)',
                'survey.form.choice.super' => 'super (9/9)',
            ],
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'survey.form.choice.placeholder',
            'constraints' => [
                new NotBlank(['message' => 'survey.scale.not_blank']),
            ],
        ];
    }

    private function choiceSimpleScale(): array
    {
        return [
            'choices' => [
                'survey.form.simple_choice.weak' => 'weak (1/4)',
                'survey.form.simple_choice.rather' => 'rather (2/4)',
                'survey.form.simple_choice.good' => 'good (3/4)',
                'survey.form.simple_choice.very_good' => 'very_good (4/4)',
            ],
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'survey.form.choice.placeholder',
            'constraints' => [
                new NotBlank(['message' => 'survey.scale.not_blank']),
            ],
        ];
    }
}
