<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Services\BookService;
use Illuminate\View\View;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    )
    {
    }

    public
    function index(): View
    {
        $books = $this->bookService->paginate();

        return view('books.index', compact('books'));
    }

    public function create(): View
    {
        return view('books.create');
    }

    public function show(int $id): View
    {
        $book = $this->bookService->getItemById($id);

        return view('books.show', compact('book'));
    }

    public function store(StoreBookRequest $request)
    {
        $this->bookService->create($request->validated());

        return redirect()->route('books.index');
    }
}
