<?php

namespace App\Helper;

class PaginationHelper
{
    /**
     * @param int $currentPage
     * @param int $totalCount
     * @param int $perPage
     *
     * @return bool
     */
    public function hasNextPage(int $currentPage, int $totalCount, int $perPage): bool
    {
        return ($currentPage * $perPage) < $totalCount;
    }

    /**
     * @param int $currentPage
     * @param int $totalCount
     * @param int $perPage
     *
     * @return bool
     */
    public function hasPreviousPage(int $currentPage, int $totalCount, int $perPage): bool
    {
        return $currentPage > 1;
    }
}