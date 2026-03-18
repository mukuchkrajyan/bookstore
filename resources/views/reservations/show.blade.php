<x-app-layout>

    <div class="max-w-4xl mx-auto p-6">

        <h2 class="text-2xl font-semibold mb-6">
            Reservation Details
        </h2>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <strong>User</strong>
                    <div class="text-gray-700">
                        {{ $reservation->user->name ?? '-' }}
                    </div>
                </div>

                <div>
                    <strong>Book</strong>
                    <div class="text-gray-700">
                        {{ optional($reservation->book)->title
                            ? $reservation->book->title.' ('.$reservation->book->author.')'
                            : '-' }}
                    </div>
                </div>

                <div>
                    <strong>Quantity</strong>
                    <div class="text-gray-700">
                        {{ $reservation->quantity }}
                    </div>
                </div>

                <div>
                    <strong>Status</strong>
                    <div>
                        @php($status    =   $reservation->status->value)
                        @if($status === 'pending')
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                            Pending
                        </span>
                        @elseif($status === 'confirmed')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                            Confirmed
                        </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                            Cancelled
                        </span>
                        @endif

                    </div>
                </div>

                <div>
                    <strong>Expires At</strong>
                    <div class="text-gray-700">
                        {{ $reservation->expires_at }}
                    </div>
                </div>

                <div>
                    <strong>Created At</strong>
                    <div class="text-gray-700">
                        {{ $reservation->created_at }}
                    </div>
                </div>

            </div>

            <div class="pt-6 flex gap-3">

                @if($reservation->status === 'pending')

                    <form method="POST"
                          action="{{ route('reservations.confirm',$reservation->id) }}">
                        @csrf
                        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Confirm
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('reservations.cancel',$reservation->id) }}">
                        @csrf
                        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            Cancel
                        </button>
                    </form>

                @endif

                <a href="{{ route('reservations.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Back
                </a>

            </div>

        </div>

    </div>

</x-app-layout>
