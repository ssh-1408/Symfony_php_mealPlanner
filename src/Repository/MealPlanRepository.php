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

    public function findByDateAndUser(\DateTimeInterface $date, $user): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.mealDate = :date')
            ->andWhere('m.user = :user')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
