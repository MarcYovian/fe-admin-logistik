@extends('layouts.app')

@section('content')
    {{-- <div id="success-alert" class="fixed top-20 right-0 mt-4 mr-4 bg-green-500 text-white px-4 py-2 rounded shadow">
        Sukses
    </div> --}}
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
            <h1 class="text-3xl font-bold">Assets</h1>
        </div>
        <div class="w-full flex justify-end">
            <a href="{{ route('assets.create') }}" type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">New
                Asset</a>
        </div>

        <div class="p-3 mb-2">
            <div class="relative overflow-x-auto shadow-md bg-gray-800 sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-16 py-3">
                                <span class="sr-only">Image</span>
                            </th>
                            <th scope="col" class="px-6 py-3 max-w-48">
                                Asset name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Type
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 max-w-60">
                                <div class="flex items-center">
                                    Description
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 max-w-28">
                                <div class="flex items-center">
                                    Num Of Borrowing
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assets['data'] as $asset)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="p-4">
                                    <img src="{{ $asset['url_image'] }}"
                                        class="h-20 object-cover md:w-32 max-w-full max-h-full" alt="Apple Watch">
                                </td>
                                <td scope="row" class="px-6 py-4 max-w-48 font-medium text-gray-900 dark:text-white">
                                    {{ $asset['name'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $asset['type'] }}
                                </td>
                                <td class="px-6 py-4 max-w-60">
                                    {!! Str::limit($asset['description'], 50) !!}
                                </td>
                                <td class="px-6 py-4 max-w-28 text-center">
                                    @if (!empty($asset['borrowing_date']))
                                        {{ count($asset['borrowing_date']) }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('assets.show', $asset['id']) }}"
                                            class="font-medium text-green-600 dark:text-green-500 hover:underline">Show</a>

                                        @if ($asset['admin']['id'] == $admin['id'])
                                            <a href="{{ route('assets.edit', $asset['id']) }}"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                            <form action="{{ route('assets.destroy', $asset['id']) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this asset?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <a href="#"
                                                class="font-medium text-blue-400 dark:text-blue-400 cursor-not-allowed"
                                                disabled>Edit</a>
                                            <button type="button"
                                                class="font-medium text-red-400 dark:text-red-400 cursor-not-allowed"
                                                disabled>
                                                Delete
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
                    aria-label="Table navigation">
                    <span
                        class="ms-2 text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $assets['meta']['from'] }} -
                            {{ $assets['meta']['to'] }}</span>
                        of <span
                            class="font-semibold text-gray-900 dark:text-white">{{ $assets['meta']['total'] }}</span></span>
                    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                        @if ($page > 1)
                            <li>
                                <a href="{{ route('assets.index', ['page' => $page - 1]) }}"
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{!! $assets['meta']['links'][0]['label'] !!}</a>
                            </li>
                        @endif
                        @if ($page >= 3)
                            <li>
                                <a href="{{ route('assets.index', ['page' => 1]) }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>

                            </li>
                            @if ($page != 3)
                                <li>
                                    <div
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        ...</div>
                                </li>
                            @endif
                        @endif

                        @for ($i = max(1, $page - 1); $i <= min($page + 2, $assets['meta']['last_page']); $i++)
                            <li>
                                <a href="{{ route('assets.index', ['page' => $i]) }}"
                                    class="flex items-center justify-center px-3 h-8 {{ $assets['meta']['links'][$i]['label'] == $page ? 'text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-white' : 'leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' }} border border-gray-300 dark:border-gray-700">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($page < $assets['meta']['last_page'] - 2)
                            <li>
                                <div
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    ...</div>
                            </li>
                            <li>
                                <a href="{{ route('assets.index', ['page' => $assets['meta']['last_page']]) }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $assets['meta']['last_page'] }}</a>

                            </li>
                        @endif

                        @if ($page < $assets['meta']['last_page'])
                            <li>
                                <a href="{{ route('assets.index', ['page' => $page + 1]) }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{!! $assets['meta']['links'][$assets['meta']['last_page'] + 1]['label'] !!}</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>

        {{-- <div class="p-3 mb-2 bg-blue-400 text-white">
            <pre>{{ json_encode($assets, JSON_PRETTY_PRINT) }}</pre>
        </div> --}}
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
