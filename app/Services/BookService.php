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

    public function availableBooks()
    {
        return Book::latest()->where('stock', '>', 0)->get();
    }

    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function getItemById(int $id): Book
    {
        return Book::findOrFail($id);
    }

    public function hasEnoughStock(int $bookId, int $quantity): bool
    {
        $book = $this->getItemById($bookId);

        return $book->stock >= $quantity;
    }

    public function findForUpdate(int $id): Book
    {
        return Book::query()
            ->lockForUpdate()
            ->findOrFail($id);
    }
}
