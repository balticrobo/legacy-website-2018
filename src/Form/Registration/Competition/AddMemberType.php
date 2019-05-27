<?php declare(strict_types=1);

namespace BalticRobo\Website\Form\Registration\Competition;

use BalticRobo\Website\Adapter\Enum\ShirtTypeEnum;
use BalticRobo\Website\Model\Registration\Competition\AddMemberDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('forename', TextType::class, [
                'label' => 'competitor_zone.registration.form.forename',
            ])
            ->add('surname', TextType::class, [
                'label' => 'competitor_zone.registration.form.surname',
            ])
            ->add('shirtType', ChoiceType::class, [
                'label' => 'competitor_zone.registration.form.shirt_type',
                'choices' => ShirtTypeEnum::getFormData(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddMemberDTO::class,
        ]);
    }
}
