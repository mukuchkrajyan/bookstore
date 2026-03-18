<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {}

    public function index(): JsonResponse
    {
        $books = $this->bookService->availableBooks();

        return response()->json($books);
    }
}