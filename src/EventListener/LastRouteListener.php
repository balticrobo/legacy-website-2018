<?php declare(strict_types=1);

namespace BalticRobo\Website\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\KernelEvents;

class LastRouteListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => [['onKernelRequest', 30]]];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST !== $event->getRequestType()
            || '_' === $event->getRequest()->get('_route')[0]) {
            return null;
        }
        $thisRoute = $event->getRequest()->getSession()->get('this_route', []);
        $routeData = [
            'name' => $event->getRequest()->get('_route'),
            'params' => $event->getRequest()->get('_route_params'),
        ];
        // Do not save same matched route twice
        if ($thisRoute === $routeData) {
            return null;
        }
        $event->getRequest()->getSession()->set('last_route', $thisRoute);
        $event->getRequest()->getSession()->set('this_route', $routeData);
    }
}
