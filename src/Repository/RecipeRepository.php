<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * Returns all approved recipes.
     *
     * @return Recipe[]
     */
    public function findApprovedRecipes(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.approvedByAdmin = :approved')
            ->setParameter('approved', true)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns latest approved recipes limited by number.
     *
     * @param int $limit
     * @return Recipe[]
     */
    public function findLatestApprovedRecipes(int $limit = 5): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.approvedByAdmin = :approved')
            ->setParameter('approved', true)
            ->orderBy('r.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    // Add your own custom methods below if needed
}
