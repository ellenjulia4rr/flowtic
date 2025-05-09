<?php

namespace App\Repository;

use App\Filter\AbstractFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class AbstractRepository extends ServiceEntityRepository
{
    /**
     * Main class referring to the repository
     * @var string
     */
    protected static mixed $class = self::class;

    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, static::$class);
    }

    public function findByFilter(
        AbstractFilter $filter
    ): Query|QueryBuilder
    {
        $queryReturn = $filter->isQueryReturn();
        $qb = $this->createQueryBuilder('entity');

        $qb
            ->andWhere('entity.status = :status')
            ->setParameter('status', $filter->getStatus())
        ;

        return $queryReturn ? $qb->getQuery() : $qb;
    }
}