<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Event;

use BalticRobo\Website\Entity\Competition\Competition;
use BalticRobo\Website\Entity\Rule\Rule;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="event_competitions")
 * @ORM\Entity
 */
class EventCompetition
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Event\Event", inversedBy="competitions")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Competition\Competition")
     */
    private $competition;

    /**
     * @ORM\OneToMany(targetEntity="BalticRobo\Website\Entity\Rule\Rule", mappedBy="eventCompetition")
     */
    private $rules;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getCompetition(): Competition
    {
        return $this->competition;
    }

    public function getRuleByLocale(string $locale): Rule
    {
        return $this->rules->filter(function (Rule $rule) use ($locale) {
            if ($rule->getLocale() === $locale) {
                return $rule;
            }

            return null;
        })->first();
    }
}
