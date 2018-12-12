<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Newsletter;

use BalticRobo\Website\Model\Newsletter\NewsletterEmailDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class NewsletterEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, [
            'label' => 'newsletter.form.email',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsletterEmailDTO::class,
        ]);
    }
}
