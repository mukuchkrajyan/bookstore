<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function paginate(int $perPage = 10)
    {
        return Book::query()
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function getItemById(int $id): Book
    {
        return Book::findOrFail($id);
    }

    public function findForUpdate(int $id): Book
    {
        return Book::query()
            ->lockForUpdate()
            ->findOrFail($id);
    }
}
