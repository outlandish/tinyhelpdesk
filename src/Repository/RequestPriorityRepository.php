<?php

namespace App\Repository;

use App\Entity\RequestPriority;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RequestPriority|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequestPriority|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequestPriority[]    findAll()
 * @method RequestPriority[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestPriorityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestPriority::class);
    }
}
