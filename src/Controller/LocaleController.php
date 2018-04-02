<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\LocaleService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/locale")
 */
class LocaleController extends Controller
{
    private $localeService;

    public function __construct(LocaleService $localeService)
    {
        $this->localeService = $localeService;
    }

    /**
     * @Route("/change/{locale}", requirements={"locale" = "[a-zA-Z]{1,8}"})
     * @Method("POST")
     */
    public function changeLocaleAction(string $locale, Request $request): Response
    {
        if ($this->localeService->isAvailableLocale($locale)) {
            $request->getSession()->set('_locale', $locale);
        }
        $referer = $request->getSession()->get('last_route');
        if (!isset($referer['name']) || !$referer['name']) {
            $referer = [
                'name' => 'balticrobo_website_default_home',
                'params' => [],
            ];
        }

        return $this->redirectToRoute($referer['name'], $referer['params']);
    }
}
