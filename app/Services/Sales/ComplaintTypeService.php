<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateComplaintTypeDTO;

class ComplaintTypeService
{
    public function __construct(
        private ComplaintTypeDAO $dao,
    ) {}

    public function index()
    {
        return $this->dao->index();
    }

    public function store(CreateComplaintTypeDTO $dto)
    {
        return $this->dao->store($dto);
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
