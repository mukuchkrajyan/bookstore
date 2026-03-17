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
    public
    function paginate(int $perPage = 10)
    {
        return Reservation::query()
            ->latest()
            ->paginate($perPage);
    }

    public
    function getItemById(int $id): Reservation
    {
        return Reservation::findOrFail($id);
    }

    public function create(int $userId, int $bookId, int $quantity): Reservation
    {
        return DB::transaction(function () use ($userId, $bookId, $quantity) {

            $book = Book::query()
                ->lockForUpdate()
                ->findOrFail($bookId);

            if ($book->stock < $quantity) {
                throw new RuntimeException('Insufficient stock');
            }

            $hasPendingReservation = Reservation::query()
                ->where('user_id', $userId)
                ->where('book_id', $bookId)
                ->where('status', ReservationStatus::Pending)
                ->lockForUpdate()
                ->exists();

            if ($hasPendingReservation) {
                throw new RuntimeException('User already has pending reservation');
            }

            $reservation = Reservation::create([
                'user_id' => $userId,
                'book_id' => $bookId,
                'quantity' => $quantity,
                'status' => ReservationStatus::Pending,
                'expires_at' => now()->addMinutes(30),
            ]);

            $book->decrement('stock', $quantity);

            DB::afterCommit(function () use ($reservation) {
                event(new ReservationCreated($reservation));
            });

            return $reservation;
        });
    }

    public function updateStatus(int $id, ReservationStatus $status): void
    {
        DB::transaction(function () use ($id, $status) {

            $reservation = Reservation::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if ($reservation->status === ReservationStatus::Pending &&
                $status === ReservationStatus::Cancelled) {

                $reservation->book()
                    ->lockForUpdate()
                    ->first()
                    ->increment('stock', $reservation->quantity);
            }

            $reservation->update([
                'status' => $status
            ]);

        });
    }

    public function cancelExpired(): int
    {
        return DB::transaction(function () {

            $reservations = Reservation::query()
                ->where('status', ReservationStatus::Pending)
                ->where('expires_at', '<', now())
                ->lockForUpdate()
                ->get();

            foreach ($reservations as $reservation) {

                $reservation->book
                    ->increment('stock', $reservation->quantity);

                $reservation->update([
                    'status' => ReservationStatus::Cancelled
                ]);
            }

            return $reservations->count();
        });
    }

}
