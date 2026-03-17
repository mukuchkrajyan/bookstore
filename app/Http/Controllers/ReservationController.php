<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request, ReservationService $service)
    {
        $service->reserve(
            auth()->id(),
            $request->book_id,
            $request->quantity
        );

        return back()->with('success','Reserved');
    }
}
