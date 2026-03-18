<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\BookService;
use App\Services\ReservationService;

class StoreReservationRequest extends FormRequest
{
private int $userId;
private BookService $bookService;
private ReservationService $reservationService;

    public function __construct()
    {
        parent::__construct();

        $this->userId = auth()->id();

        $this->bookService = app(BookService::class);
        $this->reservationService = app(ReservationService::class);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            if ($validator->errors()->isEmpty()) {
                $bookId = (int)$this->input('book_id');
                $quantity = (int)$this->input('quantity');

                if ($this->reservationService->hasPendingReservation($this->userId, $bookId)) {
                    $validator->errors()->add(
                        'book_id', __('You already have a pending reservation for this book.')
                    );
                }

                if (!$this->bookService->hasEnoughStock($bookId, $quantity)) {
                    $validator->errors()->add(
                        'quantity', __('Requested quantity exceeds available stock.')
                    );
                }
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors()
            ], 422)
        );
    }
}