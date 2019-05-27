<?php declare(strict_types=1);

namespace BalticRobo\Website\Form\Cms;

use BalticRobo\Website\Adapter\Enum\PartnerTypeEnum;
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
                'label' => 'cms.partner.name',
                'attr' => [
                    'placeholder' => 'Acme Corp',
                ],
            ])
            ->add('url', TextType::class, [
                'label' => 'cms.partner.url',
                'attr' => [
                    'placeholder' => 'https://acme.com',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'cms.partner.type',
                'choices' => PartnerTypeEnum::getFormData(),
            ])
            ->add('sortOrder', NumberType::class, [
                'label' => 'cms.partner.sort_order',
                'data' => 0,
            ])
            ->add('file', AddFileWithoutDescriptionType::class, [
                'label' => 'cms.partner.logo_file',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddPartnerDTO::class,
        ]);
    }
}
