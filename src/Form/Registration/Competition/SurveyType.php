<?php declare(strict_types=1);

namespace BalticRobo\Website\Form\Registration\Competition;

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
            ->add('age', ChoiceType::class, array_merge($params, $this->choiceAge()))
            ->add('do_you_go_on_such_events', ChoiceType::class, array_merge($params, $this->choiceYesNo()))
            ->add('do_you_think_it_was_something_new', ChoiceType::class, array_merge($params, $this->choiceYesNo()))
            ->add(
                'do_you_think_two_day_event_was_great_idea',
                ChoiceType::class,
                array_merge($params, $this->choiceYesNo())
            )
            ->add('did_you_take_part_in_conference', ChoiceType::class, array_merge($params, $this->choiceYesNo()))
            ->add('scale_atmosphere', ChoiceType::class, array_merge($params, $this->choiceScale()))
            ->add('scale_organization', ChoiceType::class, array_merge($params, $this->choiceScale()))
            ->add('scale_service_area', ChoiceType::class, array_merge($params, $this->choiceScale()))
            ->add('scale_prize', ChoiceType::class, array_merge($params, $this->choiceScale(true)))
            ->add('scale_sumo_dojo', ChoiceType::class, array_merge($params, $this->choiceScale(true)))
            ->add('scale_line_follower_track', ChoiceType::class, array_merge($params, $this->choiceScale(true)))
            ->add('scale_line_follower_3d_track', ChoiceType::class, array_merge($params, $this->choiceScale(true)))
            ->add('scale_mouse_labyrinth', ChoiceType::class, array_merge($params, $this->choiceScale(true)))
            ->add('scale_communication', ChoiceType::class, array_merge($params, $this->choiceScale()))
            ->add('scale_tech_preparation', ChoiceType::class, array_merge($params, $this->choiceScale()))
            ->add('scale_it_preparation', ChoiceType::class, array_merge($params, $this->choiceScale()))
            ->add('scale_graphic', ChoiceType::class, array_merge($params, $this->choiceScale()))
            ->add('scale_overall_score', ChoiceType::class, array_merge($params, $this->choiceScale()))
            ->add('how_did_you_know_about_event', TextType::class, array_merge($params, [
                'constraints' => [
                    new NotBlank(['message' => 'survey.text.not_blank']),
                    new Length(['min' => 3, 'minMessage' => 'survey.text.length.min']),
                ],
            ]))
            ->add('will_you_come_next_year', ChoiceType::class, array_merge($params, $this->choiceYesNo()))
            ->add('notes', TextareaType::class, $params)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SurveyDTO::class,
            'empty_data' => function (FormInterface $form) {
                return new SurveyDTO([
                    'age' => $form->get('age')->getData(),
                    'do_you_go_on_such_events' => $form->get('do_you_go_on_such_events')->getData(),
                    'do_you_think_it_was_something_new' => $form->get('do_you_think_it_was_something_new')->getData(),
                    'do_you_think_two_day_event_was_great_idea' => $form
                        ->get('do_you_think_two_day_event_was_great_idea')
                        ->getData(),
                    'did_you_take_part_in_conference' => $form->get('did_you_take_part_in_conference')->getData(),
                    'scale_atmosphere' => $form->get('scale_atmosphere')->getData(),
                    'scale_organization' => $form->get('scale_organization')->getData(),
                    'scale_service_area' => $form->get('scale_service_area')->getData(),
                    'scale_prize' => $form->get('scale_prize')->getData(),
                    'scale_sumo_dojo' => $form->get('scale_sumo_dojo')->getData(),
                    'scale_line_follower_track' => $form->get('scale_line_follower_track')->getData(),
                    'scale_line_follower_3d_track' => $form->get('scale_line_follower_3d_track')->getData(),
                    'scale_mouse_labyrinth' => $form->get('scale_mouse_labyrinth')->getData(),
                    'scale_communication' => $form->get('scale_communication')->getData(),
                    'scale_tech_preparation' => $form->get('scale_tech_preparation')->getData(),
                    'scale_it_preparation' => $form->get('scale_it_preparation')->getData(),
                    'scale_graphic' => $form->get('scale_graphic')->getData(),
                    'scale_overall_score' => $form->get('scale_overall_score')->getData(),
                    'how_did_you_know_about_event' => $form->get('how_did_you_know_about_event')->getData(),
                    'will_you_come_next_year' => $form->get('will_you_come_next_year')->getData(),
                    'notes' => $form->get('notes')->getData(),
                ], RegistrationTypeEnum::COMPETITION);
            },
        ]);
    }

    private function choiceAge(): array
    {
        return [
            'choices' => [
                '< 13' => '12-',
                '13 - 16' => '13-16',
                '17 - 20' => '17-20',
                '21 - 24' => '21-24',
                '25 - 28' => '25-28',
                '> 28' => '29+',
            ],
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'survey.form.choice.placeholder',
            'constraints' => [
                new NotBlank(['message' => 'survey.age.not_blank']),
            ],
        ];
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

    private function choiceScale(bool $withoutAnswer = false): array
    {
        $choices = [
            'survey.form.choice.very_weak' => 'very_weak (1/9)',
            'survey.form.choice.weak' => 'weak (2/9)',
            'survey.form.choice.more_or_less' => 'more_or_less (3/9)',
            'survey.form.choice.rather' => 'rather (4/9)',
            'survey.form.choice.could_be_better' => 'could_be_better (5/9)',
            'survey.form.choice.its_ok' => 'its_ok (6/9)',
            'survey.form.choice.very_good' => 'very_good (7/9)',
            'survey.form.choice.great' => 'great (8/9)',
            'survey.form.choice.super' => 'super (9/9)',
        ];
        if ($withoutAnswer) {
            $choices = array_merge(['survey.form.choice.dont_know' => 'dont_know (0/9)'], $choices);
        }

        return [
            'choices' => $choices,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'survey.form.choice.placeholder',
            'constraints' => [
                new NotBlank(['message' => 'survey.scale.not_blank']),
            ],
        ];
    }
}
