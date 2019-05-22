<?php declare(strict_types=1);

namespace BalticRobo\Website\Service\Storage;

use BalticRobo\Website\Entity\Storage\File;
use BalticRobo\Website\Model\Cms\AddFileDTO;
use BalticRobo\Website\Repository\FileRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Filesystem\Filesystem;

class FileService
{
    private $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function getList(int $skip, int $take): Collection
    {
        return $this->fileRepository->getRecords($skip, $take);
    }

    public function getTotal(): int
    {
        return $this->fileRepository->getTotal();
    }

    public function upload(AddFileDTO $fileDTO, \DateTimeImmutable $now): File
    {
        $this->createUploadFolderIfNotExists();
        $entity = File::createFromAddDTO($fileDTO, $now);
        $fileDTO->getFile()->move(File::LOCATION, $entity->getFilename());
        $this->fileRepository->save($entity);

        return $entity;
    }

    private function createUploadFolderIfNotExists(): void
    {
        $filesystem = new Filesystem();
        if (!$filesystem->exists(File::LOCATION)) {
            $filesystem->mkdir(File::LOCATION);
        }
    }
}
