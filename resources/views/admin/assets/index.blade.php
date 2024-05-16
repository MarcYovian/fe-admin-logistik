@extends('layouts.app')

@section('content')
    <main class="md:col-span-9 lg:col-span-10 md:px-4">
        <div class="flex justify-between flex-wrap md:flex-nowrap items-center pt-3 pb-2 mb-3 border-b dark:text-white">
            <h1 class="text-3xl font-bold">Assets</h1>
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
                                    <img src="{{ $asset['image_Path'] }}"
                                        class="h-20 object-cover md:w-32 max-w-full max-h-full" alt="Apple Watch">
                                </td>
                                <td scope="row" class="px-6 py-4 max-w-48 font-medium text-gray-900 dark:text-white">
                                    {{ $asset['name'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $asset['type'] }}
                                </td>
                                <td class="px-6 py-4 max-w-60">
                                    {{ Str::limit($asset['description'], 50) }}
                                </td>
                                <td class="px-6 py-4 max-w-28 text-center">
                                    @if (!empty($asset['borrowing_date']))
                                        {{ count($asset['borrowing_date']) }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('assets.details', ['id' => $asset['id']]) }}"
                                        class="ms-2 font-medium text-green-600 dark:text-green-500 hover:underline">Show</a>
                                    <a href="#"
                                        class="ms-2 font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <a href="#"
                                        class="ms-2 font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
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
                                <a href="{{ route('assets', ['page' => $page - 1]) }}"
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{!! $assets['meta']['links'][0]['label'] !!}</a>
                            </li>
                        @endif
                        @if ($page >= 3)
                            <li>
                                <a href="{{ route('assets', ['page' => 1]) }}"
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
                                <a href="{{ route('assets', ['page' => $i]) }}"
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
                                <a href="{{ route('assets', ['page' => $assets['meta']['last_page']]) }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $assets['meta']['last_page'] }}</a>

                            </li>
                        @endif

                        @if ($page < $assets['meta']['last_page'])
                            <li>
                                <a href="{{ route('assets', ['page' => $page + 1]) }}"
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
