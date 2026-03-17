<?php

namespace App\Services;

use App\Enums\ReservationStatus;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use App\Events\ReservationCreated;
use RuntimeException;

class ReservationService
{
    public function __construct(
        private Book $book,
        private Reservation $reservation
    ) {}

public function create(int $userId, int $bookId, int $quantity): Reservation
{
    return DB::transaction(function () use ($userId, $bookId, $quantity) {

        $book = $this->book
            ->newQuery()
            ->lockForUpdate()
            ->findOrFail($bookId);

        if ($book->stock < $quantity) {
            throw new RuntimeException('Insufficient stock');
        }

        $hasPendingReservation = $this->reservation
            ->newQuery()
            ->where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('status', ReservationStatus::Pending)
            ->lockForUpdate()
            ->exists();

        if ($hasPendingReservation) {
            throw new RuntimeException('User already has pending reservation');
        }

        $reservation = $this->reservation->create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'quantity' => $quantity,
            'status' => ReservationStatus::Pending,
        ]);

        $book->decrement('stock', $quantity);

        DB::afterCommit(function () use ($reservation) {
            event(new ReservationCreated($reservation));
        });

        return $reservation;
    });
}
}