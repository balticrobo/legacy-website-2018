<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Form\Registration\Competition;

use BalticRobo\Website\Adapter\DoctrineEnum\RegistrationTypeEnum;
use BalticRobo\Website\Entity\Competition\Competition;
use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Event\EventCompetition;
use BalticRobo\Website\Entity\Registration\Competition\Member;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use BalticRobo\Website\Model\Registration\Competition\AddConstructionDTO;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddConstructionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $event = $options['event'];
        $team = $options['team'];
        $builder
            ->add('name', TextType::class, [
                'label' => 'competitor_zone.registration.form.construction_name',
            ])
            ->add('competitions', EntityType::class, [
                'label' => 'competitor_zone.registration.form.competitions',
                'class' => Competition::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) use ($event) {
                    return $er->createQueryBuilder('c')
                        ->join(EventCompetition::class, 'ec', Join::WITH, 'c.id = ec.competition')
                        ->where('c.registrationType = :type')
                        ->andWhere('ec.event = :event')
                        ->orderBy('c.sortOrder')
                        ->setParameter('type', RegistrationTypeEnum::COMPETITION)
                        ->setParameter('event', $event);
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('creators', EntityType::class, [
                'label' => 'competitor_zone.registration.form.creators',
                'class' => Member::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) use ($team) {
                    return $er->createQueryBuilder('m')
                        ->where('m.team = :team')
                        ->setParameter('team', $team);
                },
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddConstructionDTO::class,
        ]);
        $resolver->setRequired('event');
        $resolver->setAllowedTypes('event', Event::class);
        $resolver->setRequired('team');
        $resolver->setAllowedTypes('team', Team::class);
    }
}
