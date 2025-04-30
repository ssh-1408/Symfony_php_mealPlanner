<?php

namespace App\Repository;

use App\Entity\MealPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MealPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MealPlan::class);
    }

    public function findByDate(\DateTimeImmutable $date): array
    {
        $start = $date->setTime(0, 0, 0);
        $end = $date->setTime(23, 59, 59);

        return $this->createQueryBuilder('m')
            ->andWhere('m.mealDate BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }
}
