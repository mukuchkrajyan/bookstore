<x-app-layout>

    <div class="max-w-xl mx-auto p-6">

        <h2 class="text-2xl font-semibold mb-6">
            Add Book
        </h2>

        <form method="POST" action="{{ route('books.store') }}" class="space-y-4">

            @csrf

            <div>
                <label class="block mb-1">Title</label>

                <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full border rounded p-2"
                >

                @error('title')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div>
                <label class="block mb-1">Author</label>

                <input
                        type="text"
                        name="author"
                        value="{{ old('author') }}"
                        class="w-full border rounded p-2"
                >

                @error('author')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div>
                <label class="block mb-1">Price</label>

                <input
                        type="number"
                        step="0.01"
                        name="price"
                        value="{{ old('price') }}"
                        class="w-full border rounded p-2"
                >

                @error('price')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div>
                <label class="block mb-1">Stock</label>

                <input
                        type="number"
                        name="stock"
                        value="{{ old('stock') }}"
                        class="w-full border rounded p-2"
                >

                @error('stock')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">

                <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Save
                </button>

                <a
                        href="{{ route('books.index') }}"
                        class="px-4 py-2 bg-gray-300 rounded"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</x-app-layout>