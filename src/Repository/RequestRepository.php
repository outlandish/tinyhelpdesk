<?php

namespace App\Repository;

use App\Entity\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Request|null find($id, $lockMode = null, $lockVersion = null)
 * @method Request|null findOneBy(array $criteria, array $orderBy = null)
 * @method Request[] findAll()
 * @method Request[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Request::class);
    }

    /**
     * @param UserInterface $user
     *
     * @return Request[] Returns an array of Request objects
     */
    public function findByCreator(UserInterface $user)
    {
        return $this->createQueryBuilder('r')
            ->where('r.creator = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param UserInterface $user
     *
     * @return Request[] Returns an array of Request objects
     */
    public function findByAssignee(UserInterface $user)
    {
        return $this->createQueryBuilder('r')
            ->where('r.creator = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
}
