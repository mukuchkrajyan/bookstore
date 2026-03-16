<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use App\Events\ReservationCreated;
use Exception;

class ReservationService
{
    public function create(int $userId, int $bookId, int $quantity): Reservation
    {
        return DB::transaction(function () use ($userId, $bookId, $quantity) {

            $book = Book::where('id', $bookId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->stock < $quantity) {
                throw new Exception('Insufficient stock');
            }

            $exists = Reservation::where('user_id', $userId)
                ->where('book_id', $bookId)
                ->where('status', 'pending')
                ->exists();

            if ($exists) {
                throw new Exception('Already has active reservation');
            }

            $book->decrement('stock', $quantity);

            $reservation = Reservation::create([
                'user_id' => $userId,
                'book_id' => $bookId,
                'quantity' => $quantity,
                'status' => 'pending',
            ]);

            event(new ReservationCreated($reservation));

            return $reservation;
        });
    }
}
