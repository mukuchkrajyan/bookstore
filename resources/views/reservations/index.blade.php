<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        <h2 class="text-2xl font-semibold mb-6">
            Reservations
        </h2>

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="min-w-full">

                <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-left">Book</th>
                    <th class="px-4 py-3 text-left">Quantity</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Expires</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
                </thead>

                <tbody class="divide-y">

                @forelse($reservations as $reservation)

                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3">
                            {{ $reservation->id }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $reservation->user->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $reservation->book->title ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $reservation->quantity }}
                        </td>

                        <td class="px-4 py-3">
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

                        </td>

                        <td class="px-4 py-3">
                            {{ $reservation->expires_at }}
                        </td>

                        <td class="px-4 py-3 flex gap-3">

                            <a href="{{ route('reservations.show',$reservation->id) }}"
                               class="text-blue-600 hover:underline">
                                View
                            </a>

                            @if($status === 'pending')

                                <form method="POST"
                                      action="{{ route('reservations.confirm',$reservation->id) }}">
                                    @csrf
                                    <button class="text-green-600 hover:underline">
                                        Confirm
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('reservations.cancel',$reservation->id) }}">
                                    @csrf
                                    <button class="text-red-600 hover:underline">
                                        Cancel
                                    </button>
                                </form>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            No reservations found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $reservations->links() }}
        </div>

    </div>

</x-app-layout>
