<?php

namespace App\Entity\Trait;

use App\Constants\SerializerGroups;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

trait StatusTrait
{
    #[ORM\Column(type: Types::STRING, length: 50)]
    #[Serializer\Groups([SerializerGroups::DEFAULT])]
    private string $status = 'ACTIVE';

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}