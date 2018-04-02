<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

class LocaleService
{
    private $availableLocales;

    public function __construct(array $availableLocales)
    {
        $this->availableLocales = $availableLocales;
    }

    public function isAvailableLocale(string $locale): bool
    {
        return in_array(strtolower($locale), $this->availableLocales);
    }
}
