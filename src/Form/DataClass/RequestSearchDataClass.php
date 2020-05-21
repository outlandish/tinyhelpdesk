<?php

namespace App\Form\DataClass;

use App\Entity\User;

class RequestSearchDataClass
{
    /**
     * @var User
     */
    private $creator;

    /**
     * @var User
     */
    private $assignee;

    /**
     * @var int
     */
    private $page = 1;

    /**
     * @var array
     */
    private $sortBy = [];

    /**
     * @return User|null
     */
    public function getCreator(): ?User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator(User $creator): void
    {
        $this->creator = $creator;
    }

    /**
     * @return User|null
     */
    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    /**
     * @param User $assignee
     */
    public function setAssignee(User $assignee): void
    {
        $this->assignee = $assignee;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int|null $page
     */
    public function setPage(?int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return array
     */
    public function getSortBy(): array
    {
        return $this->sortBy;
    }

    /**
     * @param array $sortBy
     */
    public function setSortBy(array $sortBy): void
    {
        $this->sortBy = $sortBy;
    }
}