<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Cms;

class AddPartnerDTO
{
    private $name;
    private $url;
    private $type;
    private $sortOrder;
    private $file;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }

    public function getFile(): ?AddFileDTO
    {
        return $this->file;
    }

    public function setFile(AddFileDTO $file): void
    {
        $this->file = $file;
    }
}
