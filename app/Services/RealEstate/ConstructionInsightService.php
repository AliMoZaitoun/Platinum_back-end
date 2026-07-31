<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\ConstructionInsightDAO;

class ConstructionInsightService
{
    public function __construct(
        private ConstructionInsightDAO $dao
    ) {}

    public function index(array $filters = [])
    {
        return $this->dao->index($filters);
    }

    public function markAsRead(int $id)
    {
        return $this->dao->markAsRead($id);
    }
}
