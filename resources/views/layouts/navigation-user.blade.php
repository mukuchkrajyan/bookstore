<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        <div class="text-lg font-semibold">
            User Interface
        </div>

        <div class="relative">
            <details class="group">
                <summary class="cursor-pointer flex items-center gap-2">
                    <span>Welcome, {{ auth()->user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>

                <div class="absolute right-0 mt-2 w-40 bg-white border rounded shadow">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            </details>
        </div>

    </div>
</nav>
