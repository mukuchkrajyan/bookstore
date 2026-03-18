<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService $reservationService
    )
    {

    }

    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();

        $reservation = $this->reservationService->create(
            auth()->user()->id,
            $data['book_id'],
            $data['quantity']
        );

        return response()->json($reservation, 201);
    }
}