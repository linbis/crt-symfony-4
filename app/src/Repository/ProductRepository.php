<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param Category $category
     * @return QueryBuilder
     */
    public function getQueryForCategory(Category $category): QueryBuilder
    {
        $builder = $this->createQueryBuilder('p');
        $builder->leftJoin('p.images', 'i')->addSelect('i');
        $builder->where($builder->expr()->eq('p.category', $category->getId()));
        $builder->orderBy($builder->expr()->desc('p.updatedAt'));

        return $builder;
    }

    /**
     * @param int $maxResults
     * @return Criteria
     */
    public static function createNewestCriteria(int $maxResults = Product::PER_PAGE): Criteria
    {
        return Criteria::create()
            ->orderBy(['updatedAt' => Criteria::DESC])
            ->setMaxResults($maxResults);
    }
}