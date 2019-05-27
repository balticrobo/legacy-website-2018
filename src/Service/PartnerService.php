<?php declare(strict_types=1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Adapter\Enum\PartnerTypeEnum;
use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Event\Partner;
use BalticRobo\Website\Model\Cms\AddPartnerDTO;
use BalticRobo\Website\Repository\PartnerRepository;
use BalticRobo\Website\Service\Storage\FileService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class PartnerService
{
    private $partnerRepository;
    private $fileService;

    public function __construct(PartnerRepository $partnerRepository, FileService $file)
    {
        $this->partnerRepository = $partnerRepository;
        $this->fileService = $file;
    }

    public function getList(int $skip, int $take): Collection
    {
        return $this->partnerRepository->getRecords($skip, $take);
    }

    public function getForEvent(Event $event): Collection
    {
        $records = array_reduce(PartnerTypeEnum::getAvailableTypes(), function (array $types, int $type) use ($event) {
            $typeName = PartnerTypeEnum::getName($type);
            $types[$typeName] = $this->partnerRepository->getRecordsByEventAndType($event, $type);

            return $types;
        }, []);

        return new ArrayCollection($records);
    }

    public function getTotal(): int
    {
        return $this->partnerRepository->getTotal();
    }

    public function add(AddPartnerDTO $partnerDTO, Event $event, \DateTimeImmutable $now): void
    {
        $type = PartnerTypeEnum::getName($partnerDTO->getType());
        $partnerDTO->getFile()->setDescription("Partner: {$partnerDTO->getName()}; Type: {$type}; Image: Logo");
        $file = $this->fileService->upload($partnerDTO->getFile(), $now);

        $this->partnerRepository->save(Partner::createFromAddDTO($partnerDTO, $file, $event, $now));
    }
}
