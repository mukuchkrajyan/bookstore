<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService $reservationService
    )
    {
    }

    public function index(): View
    {
        $reservations = $this->reservationService->paginate();

        return view('reservations.index', compact('reservations'));
    }

    public function show(int $id): View
    {
        $reservation = $this->reservationService->getItemById($id);

        return view('reservations.show', compact('reservation'));
    }

    public function cancel(int $id)
    {
        $this->reservationService->updateStatus($id, ReservationStatus::Cancelled);

        return back();
    }

    public function confirm(int $id)
    {
        $this->reservationService->updateStatus($id, ReservationStatus::Confirmed);

        return back();
    }
}
