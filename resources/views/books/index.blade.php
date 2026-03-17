<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Books</h2>

            <a href="{{ route('books.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Add Book
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="min-w-full border">

                <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">Author</th>
                    <th class="px-4 py-2 text-left">Stock</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
                </thead>

                <tbody class="divide-y">

                @forelse($books as $book)

                    <tr class="hover:bg-gray-100">

                        <td class="px-4 py-2">{{ $book->id }}</td>
                        <td class="px-4 py-2">{{ $book->title }}</td>
                        <td class="px-4 py-2">{{ $book->author }}</td>
                        <td class="px-4 py-2">{{ $book->stock }}</td>

                        <td class="px-4 py-2 space-x-2">

                            <a href="{{ route('books.show',$book->id) }}" class="text-blue-600 hover:underline">
                                View
                            </a>

                            <a href="#" class="text-yellow-600 hover:underline cursor-not-allowed">
                                Edit
                            </a>

                            <button class="text-red-600 hover:underline cursor-not-allowed">
                                Delete
                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center py-4">
                            No books found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            <div class="mt-4">
                {{ $books->links() }}
            </div>
        </div>

    </div>

</x-app-layout>
