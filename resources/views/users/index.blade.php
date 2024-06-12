@extends('layouts.app')

@section('content')
    <div class="p-3 mb-2">
        <div class="relative overflow-x-auto shadow-md bg-gray-800 sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 max-w-48">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                Email
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 max-w-60">
                            <div class="flex items-center">
                                Type
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets['data'] as $data)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['email'] }}</td>
                            <td>{{ $data['type'] }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <form action="{{ route('users.update', $data['id']) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to change this data?');">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="type" value="ssc" hidden>
                                        <button type="submit"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                            SSC
                                        </button>
                                    </form>
                                    <form action="{{ route('users.update', $data['id']) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to chage this data?');">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="type" value="logistik" hidden>
                                        <button type="submit"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                            Logistik
                                        </button>
                                    </form>
                                    <form action="{{ route('users.destroy', $data['id']) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this data?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                            Delete
                                        </button>
                                    </form>

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
@endsection
