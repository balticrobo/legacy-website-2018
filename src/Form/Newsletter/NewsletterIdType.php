<?php declare(strict_types=1);

namespace BalticRobo\Website\Form\Newsletter;

use BalticRobo\Website\Model\Newsletter\NewsletterIdDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

final class NewsletterIdType extends AbstractType
{
    private $postPath;

    public function __construct(RouterInterface $router)
    {
        $this->postPath = $router->generate('balticrobo_website_newsletter_optoutpost');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAction($this->postPath)->add('id', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsletterIdDTO::class,
        ]);
    }
}
