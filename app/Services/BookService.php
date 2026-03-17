<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function __construct(
        private Book $model
    ) {}

    public
    function paginate(int $perPage = 10)
    {
        return $this->model
            ->newQuery()
            ->latest()
            ->paginate($perPage);
    }

    public
    function create(array $data): Book
    {
        return $this->model->create($data);
    }

    public
    function getItemById(int $id): Book
    {
        return $this->model->findOrFail($id);
    }

    public
    function findForUpdate(int $id): Book
    {
        return $this->model
            ->newQuery()
            ->lockForUpdate()
            ->findOrFail($id);
    }
}