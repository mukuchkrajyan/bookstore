<?php

namespace App\Console\Commands;

use App\Services\ReservationService;
use Illuminate\Console\Command;
use App\Models\Reservation;

class CancelExpiredReservations extends Command
{
    protected $signature = 'reservations:cancel-expired';

    protected $description = 'Cancel expired pending reservations';

    public function handle(ReservationService $reservationService): void
    {
        $count = $reservationService->cancelExpired();

        $this->info("$count reservations cancelled.");
    }
}
