@extends('layouts.app')

@section('content')
    <main class="md:col-span-9 lg:col-span-10 md:px-4">
        <div class="flex justify-between flex-wrap md:flex-nowrap items-center pt-3 pb-2 mb-3 border-b dark:text-white">
            <h1 class="text-3xl font-bold">{{ $asset['name'] }}</h1>
        </div>

        {{-- Detail Asset Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Image Section --}}
            <div class="flex justify-center items-start">
                <img src="{{ $asset['url_image'] }}" alt="{{ $asset['name'] }}" class="w-full h-auto rounded shadow-md">
            </div>

            {{-- Information Section --}}
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Asset Information</h2>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Type</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $asset['type'] }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Description</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $asset['description'] }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Created By</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $asset['admin']['name'] }}</p>
                </div>


                <div class="flex justify-end mt-6 space-x-2">
                    @if ($admin['id'] == $asset['admin']['id'])
                        <a href="{{ route('assets.edit', $asset['id']) }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded shadow hover:bg-yellow-600 dark:bg-yellow-700 dark:hover:bg-yellow-800">
                            Edit
                        </a>
                        <form action="{{ route('assets.destroy', ['id' => $asset['id']]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this asset?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded shadow hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800">
                                Delete
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('assets.index') }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">
                        Back to Assets
                    </a>
                </div>
            </div>
        </div>

    </main>
@endsection
