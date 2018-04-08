<?php
/**
 * This file is part of oc_bilemo project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/04
 */

namespace App\Repository;

use App\Entity\Product;
use App\Services\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * ProductRepository constructor.
     *
     * @param RegistryInterface $registry
     * @param Paginator         $paginator
     */
    public function __construct(RegistryInterface $registry, Paginator $paginator)
    {
        $this->paginator = $paginator;

        parent::__construct($registry, Product::class);
    }

    /**
     * @param int|null $maxPerPage
     * @param int|null $currentPage
     *
     * @throws \LogicException
     *
     * @return \Pagerfanta\Pagerfanta
     */
    public function findAllWithPaginate($maxPerPage = null, $currentPage = null)
    {
        $qb = $this->createQueryBuilder('P');
        return $this->paginator->paginate($qb, $maxPerPage, $currentPage);
    }
}
