<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Cms;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddFileDTO
{
    private $file;
    private $description;

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
