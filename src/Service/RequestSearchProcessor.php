<?php

namespace App\Service;

use App\Entity\Request;
use App\Form\DataClass\RequestSearchDataClass;
use App\Helper\PaginationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class RequestSearchProcessor
{
    private const LIMIT_PER_PAGE = 10;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var PaginationHelper
     */
    private PaginationHelper $paginationHelper;

    public function __construct(EntityManagerInterface $manager, PaginationHelper $paginationHelper)
    {
        $this->manager = $manager;
        $this->paginationHelper = $paginationHelper;
    }

    /**
     * @param RequestSearchDataClass $dataClass
     * @return array
     */
    public function getResult(RequestSearchDataClass $dataClass): array
    {
        $totalCount = $this->getTotalCount($dataClass);
        $page = $dataClass->getPage();

        $qb = $this->getQueryBuilder();
        $this->addWhere($qb, $dataClass);
        $this->addOrderBy($qb, $dataClass->getSortBy());

        $query = $qb->getQuery();
        $this->addPagination($query, $page);

        return [
            'result' => $query->getResult(),
            'totalCount' => $totalCount,
            'hasNextPage' => $this->paginationHelper->hasNextPage($page, $totalCount, self::LIMIT_PER_PAGE),
            'hasPreviousPage' => $this->paginationHelper->hasPreviousPage($page, $totalCount, self::LIMIT_PER_PAGE),
        ];
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->manager
            ->createQueryBuilder()
            ->select('request')
            ->from(Request::class, 'request');
    }

    /**
     * @param RequestSearchDataClass $dataClass
     *
     * @return int
     */
    private function getTotalCount(RequestSearchDataClass $dataClass): int
    {
        $qb = $this->getQueryBuilder()->select('COUNT(request)');

        return $this->addWhere($qb, $dataClass)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * @param QueryBuilder $qb
     * @param RequestSearchDataClass $dataClass
     *
     * @return QueryBuilder
     */
    private function addWhere(QueryBuilder $qb, RequestSearchDataClass $dataClass)
    {
        if ($dataClass->getAssignee()) {
            $qb->andWhere('request.assignee = :assignee')
                ->setParameter('assignee', $dataClass->getAssignee());
        }

        if ($dataClass->getCreator()) {
            $qb->andWhere('request.creator = :creator')
                ->setParameter('creator', $dataClass->getCreator());
        }

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param array $sorting
     *
     * @return QueryBuilder
     */
    private function addOrderBy(QueryBuilder $qb, array $sorting): QueryBuilder
    {
        // TODO: implement the sorting

        return $qb;
    }

    /**
     * @param Query $query
     * @param int $currentPage
     *
     * @return Query
     */
    private function addPagination(Query $query, int $currentPage): Query
    {
        if ($currentPage > 1) {
            $query->setFirstResult(($currentPage - 1) * self::LIMIT_PER_PAGE);
        }

        $query->setMaxResults(self::LIMIT_PER_PAGE);

        return $query;
    }
}