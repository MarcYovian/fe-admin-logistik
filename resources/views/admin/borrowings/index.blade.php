@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div id="toast-success"
            class="fixed top-20 right-0 mt-4 mr-4 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('success') }}</div>
        </div>
    @endif

    @if (session('failed'))
        <div id="toast-danger"
            class="fixed top-20 right-0 mt-4 mr-4 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('failed') }}</div>
        </div>
    @endif

    <main class="md:col-span-9 lg:col-span-10 md:px-4">
        <div class="flex justify-between flex-wrap md:flex-nowrap items-center pt-3 pb-2 mb-3 border-b dark:text-white">
            <h1 class="text-3xl font-bold">Borrowings Asset</h1>
        </div>
        <!-- Button to create new borrowing -->
        <div class="w-full flex justify-end">
            <a href="{{ route('borrowings.create.step1') }}" type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create
                New Borrowing</a>
        </div>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">UKM Name</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Event Name</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Participants</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Event Date</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Student</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($borrowings as $borrowing)
                        <tr>
                            <td class="w-1/6 text-left py-3 px-4">{{ $borrowing['ukm_name'] }}</td>
                            <td class="w-1/6 text-left py-3 px-4">{{ $borrowing['event_name'] }}</td>
                            <td class="w-1/6 text-left py-3 px-4">{{ $borrowing['num_of_participants'] }}</td>
                            <td class="w-1/6 text-left py-3 px-4">
                                {{ \Carbon\Carbon::parse($borrowing['event_date'])->format('d M Y H:i') }}</td>
                            <td class="w-1/6 text-left py-3 px-4">{{ $borrowing['student']['name'] }}</td>
                            <td class="w-1/6 text-left py-3 px-4">{{ $borrowing['status'] }}</td>
                            <td class="w-1/6 text-left py-3 px-4">
                                <a href="{{ route('borrowings.show', $borrowing['id']) }}"
                                    class="text-blue-500 hover:underline">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var success = document.getElementById('toast-success');
            var danger = document.getElementById('toast-danger');
            if (success) {
                setTimeout(function() {
                    success.style.display = 'none';
                }, 5000); // Hide after 5 seconds
            }

            if (danger) {
                setTimeout(function() {
                    danger.style.display = 'none';
                }, 5000)
            }
        });
    </script>
@endpush
