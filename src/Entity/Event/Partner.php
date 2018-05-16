<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="event_partners")
 * @ORM\Entity
 */
class Partner
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Event\Event")
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=140)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Storage\File")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $url;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;
}
