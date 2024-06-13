@extends('layouts.app')

@push('style')
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            max-height: 500px;
            overflow-y: scroll;
            min-width: 300px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content div {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            cursor: pointer;
        }

        .dropdown-content div:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
@endpush

@section('content')
    <main class="md:col-span-9 lg:col-span-10 md:px-4">
        <div class="flex justify-between flex-wrap md:flex-nowrap items-center pt-3 pb-2 mb-3 border-b dark:text-white">
            <h1 class="text-3xl font-bold">Create Borrowings</h1>
        </div>
        <form action="{{ route('borrowing.store.step1') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="ukm_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Student Name
                </label>
                <div class="dropdown w-full">
                    <input type="text" id="student_search" onkeyup="filterStudents(this)"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for Student"
                        value="{{ old('student_search', $borrowingData['student_search'] ?? '') }}" />
                    <input type="hidden" id="student_id" name="student_id"
                        value="{{ old($borrowingData['asset_id'] ?? '') }}" />
                    <div class="dropdown-content" id="student-dropdown">
                        <!-- Dynamic options will be inserted here -->
                    </div>
                </div>
                @error('student_id')
                    <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="ukm_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    UKM Name
                </label>
                <input type="text" id="ukm_name" name="ukm_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="UKM Name" value="{{ old('ukm_name', $borrowingData['ukm_name'] ?? '') }}" />
                @error('ukm_name')
                    <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="event_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Event Name
                </label>
                <input type="text" id="event_name" name="event_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Event Name" value="{{ old('event_name', $borrowingData['event_name'] ?? '') }}" />
                @error('event_name')
                    <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="event_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Event Date
                </label>
                <input type="datetime-local" id="event_date" name="event_date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    value="{{ old('event_date', $borrowingData['event_date'] ?? '') }}" />
                @error('event_date')
                    <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="num_of_participants" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Number of Participants
                </label>
                <input type="number" id="num_of_participants" name="num_of_participants"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Number of Participants"
                    value="{{ old('num_of_participants', $borrowingData['num_of_participants'] ?? '') }}" />
                @error('num_of_participants')
                    <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                @enderror
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Next
            </button>
        </form>

    </main>
@endsection

@push('scripts')
    <script>
        let allStudents = [];

        async function fetchStudents() {
            const bearerToken = "{{ Session::get('api_token') }}";
            const response = await fetch('http://logistik-api.test/api/v1/students/', {
                headers: {
                    'Authorization': `Bearer ${bearerToken}`
                }
            });
            const data = await response.json();
            allStudents = data.data;
        }

        function filterStudents(inputElement) {
            const filter = inputElement.value.toLowerCase();
            const dropdown = document.getElementById('student-dropdown');

            dropdown.innerHTML = '';
            const filteredStudents = allStudents.filter(student => student.name.toLowerCase().includes(filter));
            filteredStudents.forEach(student => {
                const div = document.createElement('div');
                div.textContent = student.name;
                div.onclick = function() {
                    inputElement.value = student.name;
                    document.getElementById('student_id').value = student.id;
                    dropdown.innerHTML = '';
                };
                dropdown.appendChild(div);
            });
        }

        function showAllStudents(inputElement) {
            const dropdown = document.getElementById('student-dropdown');
            dropdown.innerHTML = '';
            allStudents.forEach(student => {
                const div = document.createElement('div');
                div.textContent = student.name;
                div.onclick = function() {
                    inputElement.value = student.name;
                    document.getElementById('student_id').value = student.id;
                    dropdown.innerHTML = '';
                };
                dropdown.appendChild(div);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchStudents();
        });

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('student-dropdown');
            if (!event.target.matches('#student_search')) {
                dropdown.classList.remove('show');
            }
        });
    </script>
@endpush
