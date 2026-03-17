<x-app-layout>

    <div class="max-w-3xl mx-auto p-6">

        <h2 class="text-2xl font-semibold mb-6">
            Book Details
        </h2>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">

            <div>
                <span class="font-semibold">ID:</span>
                {{ $book->id }}
            </div>

            <div>
                <span class="font-semibold">Title:</span>
                {{ $book->title }}
            </div>

            <div>
                <span class="font-semibold">Author:</span>
                {{ $book->author }}
            </div>

            <div>
                <span class="font-semibold">Price:</span>
                ${{ $book->price }}
            </div>

            <div>
                <span class="font-semibold">Stock:</span>
                {{ $book->stock }}
            </div>

        </div>

        <div class="mt-6 flex gap-3">

            <a href="{{ route('books.index') }}"
               class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Back
            </a>

        </div>

    </div>

</x-app-layout>
