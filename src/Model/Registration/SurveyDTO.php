<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Registration;

use BalticRobo\Website\Adapter\DoctrineEnum\RegistrationTypeEnum;

class SurveyDTO
{
    private $type;
    private $data;

    public function __construct(array $data, int $type)
    {
        $this->data = $data;
        $this->validateType($type);
        $this->type = $type;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getData(): array
    {
        return $this->data;
    }

    private function validateType(int $type): void
    {
        if (!in_array($type, RegistrationTypeEnum::getAvailableTypes())) {
            throw new \Exception(); // TODO: Throw correct exception
        }
    }
}
