<?php declare(strict_types=1);

namespace BalticRobo\Website\Adapter\Twig;

use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExistsExtension extends AbstractExtension
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('route_exists', function (string $route): bool {
                return null !== $this->router->getRouteCollection()->get($route);
            }),
        ];
    }
}
