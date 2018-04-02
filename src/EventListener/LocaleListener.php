<?php

declare(strict_types = 1);

namespace BalticRobo\Website\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleListener implements EventSubscriberInterface
{
    private $defaultLocale;

    private $availableLocales;

    public function __construct(string $defaultLocale, array $availableLocales)
    {
        $this->defaultLocale = $defaultLocale;
        $this->availableLocales = $availableLocales;
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => [['onKernelRequest', 17]]];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return null;
        }
        if (!$event->getRequest()->getSession()->has('_locale')) {
            $event->getRequest()->getSession()->set('_locale', $this->defaultLocale);
            $userLang = $event->getRequest()->getLanguages();
            for ($i = 0; $i < count($userLang); ++$i) {
                preg_match_all('/[a-z]{1,8}/i', $userLang[$i], $lang_parse);
                if (in_array($lang = strtolower($lang_parse[0][0]), $this->availableLocales, true)) {
                    $event->getRequest()->getSession()->set('_locale', $lang);
                    break;
                }
            }
        }
        $event->getRequest()->setLocale($event->getRequest()->getSession()->get('_locale'));
    }
}
