<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Exception\Event;

class EventnNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('event.event_not_found');
    }
}
