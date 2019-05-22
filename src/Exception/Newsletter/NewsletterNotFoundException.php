<?php declare(strict_types=1);

namespace BalticRobo\Website\Exception\Newsletter;

class NewsletterNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('newsletter.not_found');
    }
}
