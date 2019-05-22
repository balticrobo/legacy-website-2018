<?php declare(strict_types=1);

namespace BalticRobo\Website\Exception\Event;

class EventCompetitionNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('event.event_competition_not_found');
    }
}
