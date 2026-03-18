@extends('layouts.ui')

@section('content')

    <div class="max-w-5xl mx-auto p-6">

        <h2 class="text-2xl font-semibold mb-6">
            User Interface
        </h2>

        <p class="text-gray-600 mb-6">
            This is a simple user interface for testing the reservation system.
        </p>
        
        <div class="bg-white shadow rounded-lg p-6">

            <div class="mb-4">
                <strong>User:</strong>
                {{ $user->name }}
            </div>

            <div class="mb-4">
                <strong>Email:</strong>
                {{ $user->email }}
            </div>

            <div class="mt-6">
                <strong class="block mb-2">API Token:</strong>

                <div class="bg-gray-100 p-3 rounded text-sm break-all">
                    {{ $token }}
                </div>
            </div>

            <div class="mt-6 text-sm text-gray-600">
                Bearer token:
                <code class="bg-gray-200 px-2 py-1 rounded">
                    Authorization: Bearer {{ $token }}
                </code>
            </div>

        </div>

    </div>

@endsection
