<?php

namespace App\Listeners;

use App\Events\ReservationCreated;
use Illuminate\Support\Facades\Log;

class LogReservationCreated
{
    public function handle(ReservationCreated $event): void
    {
        $reservation = $event->reservation;

        Log::info('Reservation created', [
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'book_id' => $reservation->book_id,
            'quantity' => $reservation->quantity,
        ]);
    }
}