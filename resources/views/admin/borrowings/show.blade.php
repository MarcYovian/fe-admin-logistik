@extends('layouts.app')

@section('content')
    <main class="md:col-span-9 lg:col-span-10 md:px-4">
        <div class="flex justify-between flex-wrap md:flex-nowrap items-center pt-3 pb-2 mb-3 border-b dark:text-white">
            <h1 class="text-3xl font-bold">Details Borrowing</h1>
        </div>

        <div class="p-4 bg-gray-100">
            <h3 class="text-lg font-semibold">{{ $borrowing['ukm_name'] }}</h3>
            <p class="text-sm text-gray-600">{{ $borrowing['event_name'] }}</p>
        </div>

        <div class="p-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Asset
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Start Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            End Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($borrowing['detail_borrowings'] as $detail)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $detail['id'] }} <!-- Ubah ini sesuai dengan informasi aset yang ingin ditampilkan -->
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $detail['start_date'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $detail['end_date'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $detail['description'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $detail['num'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $detail['status'] }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </main>
@endsection
