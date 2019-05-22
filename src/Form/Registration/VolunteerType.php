<?php declare(strict_types=1);

namespace BalticRobo\Website\Form\Registration;

use BalticRobo\Website\Adapter\DoctrineEnum\ShirtTypeEnum;
use BalticRobo\Website\Adapter\DoctrineEnum\VolunteerArrangementEnum;
use BalticRobo\Website\Adapter\DoctrineEnum\VolunteerHelpInEnum;
use BalticRobo\Website\Model\Registration\VolunteerDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class VolunteerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'volunteer.form.name'])
            ->add('birthYear', TextType::class, ['label' => 'volunteer.form.birth_year'])
            ->add('phoneNumber', TextType::class, ['label' => 'volunteer.form.phone_number'])
            ->add('email', EmailType::class, ['label' => 'volunteer.form.email'])
            ->add('arrangementDays', ChoiceType::class, [
                'label' => 'volunteer.form.arrangement',
                'choices' => VolunteerArrangementEnum::getFormData(),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('beenVolunteer', ChoiceType::class, [
                'label' => 'volunteer.form.been_volunteer_in_previous_editions',
                'choices' => [
                    '_button.yes' => true,
                    '_button.no' => false,
                ],
                'expanded' => true,
            ])
            ->add('beenVolunteerDuties', TextareaType::class, ['label' => 'volunteer.form.been_volunteer_duties'])
            ->add('shirtType', ChoiceType::class, [
                'label' => 'volunteer.form.shirt_type',
                'choices' => ShirtTypeEnum::getFormData(),
            ])
            ->add('helpIn', ChoiceType::class, [
                'label' => 'volunteer.form.help_in',
                'choices' => VolunteerHelpInEnum::getFormData(),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('agreement', CheckboxType::class, ['label' => 'volunteer.form.agreement']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VolunteerDTO::class,
        ]);
    }
}
