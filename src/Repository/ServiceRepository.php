<?php

namespace App\Repository;

use App\Entity\Service;
use App\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

class ServiceRepository extends AbstractRepository
{
    protected static mixed $class = Service::class;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry);
    }
}