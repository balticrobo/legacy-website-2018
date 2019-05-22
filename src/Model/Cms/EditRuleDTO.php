<?php declare(strict_types=1);

namespace BalticRobo\Website\Model\Cms;

use BalticRobo\Website\Entity\Rule\Rule;

class EditRuleDTO
{
    private $content;

    public static function createFromEntity(Rule $entity): self
    {
        $dto = new self();
        $dto->content = $entity->getContent();

        return $dto;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
