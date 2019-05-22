<?php declare(strict_types=1);

namespace BalticRobo\Website\Service\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Repository\Registration\InformationRepository;
use Doctrine\Common\Collections\Collection;

class InformationService
{
    private $informationRepository;

    public function __construct(InformationRepository $information)
    {
        $this->informationRepository = $information;
    }

    public function getInformationByEvent(Event $event): Collection
    {
        return $this->informationRepository->getInformationByEvent($event);
    }
}
