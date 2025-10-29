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
            @if ($admin['type'] == 'logistik' || $admin['type'] == 'superuser')
                <button id="editButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded mb-3">
                    Edit
                </button>
            @endif
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

    <!-- Modal -->
    <div id="editModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Edit Borrowing Details
                            </h3>
                            <div class="mt-2">
                                <form id="updateForm" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @foreach ($borrowing['detail_borrowings'] as $detail)
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2"
                                                for="status-{{ $detail['id'] }}" data-asset-id="{{ $detail['asset_id'] }}">
                                                Loading...
                                            </label>
                                            <select name="status[{{ $detail['id'] }}]" id="status-{{ $detail['id'] }}"
                                                class="form-select mt-1 block w-full">
                                                <option value="PENDING"
                                                    {{ $detail['status'] == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                                <option value="APPROVED"
                                                    {{ $detail['status'] == 'APPROVED' ? 'selected' : '' }}>APPROVED
                                                </option>
                                                <option value="REJECTED"
                                                    {{ $detail['status'] == 'REJECTED' ? 'selected' : '' }}>REJECTED
                                                </option>
                                            </select>
                                        </div>
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                    <button type="button" id="closeButton"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        close
                    </button>
                    <button type="button" id="updateButton"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            document.getElementById('editModal').classList.remove('hidden');
        });

        document.getElementById('closeButton').addEventListener('click', function() {
            console.log('close');
            document.getElementById('editModal').classList.add('hidden');
        });

        document.getElementById('updateButton').addEventListener('click', function() {
            const form = $('#updateForm');
            const details = [];

            form.find('select').each(function() {
                const id = $(this).attr('id').split('-')[1];
                const status = $(this).val();
                details.push({
                    id: id,
                    status: status
                });
            });

            const data = {
                details: details
            };

            console.log(JSON.stringify(data));
            const borrowingsId = '{{ $borrowing['id'] }}';
            const token = '{{ session()->get('api_token') }}';
            console.log(borrowingsId);
            $.ajax({
                url: 'http://logistik-api.test/api/v1/borrowings/' + borrowingsId + '/approve',
                method: 'PUT',
                headers: {
                    "Authorization": "Bearer " + token
                },
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    // Tangani respons sukses
                    alert('Data berhasil diperbarui');
                    editModal.classList.add('hidden');
                    location.reload(); // Muat ulang halaman untuk memperbarui tabel
                },
                error: function(xhr, status, error) {
                    // Tangani respons gagal
                    console.log(xhr.responseJSON.errors);
                    alert('Terjadi kesalahan saat memperbarui data: ' + error);
                }
            });
        });

        $(document).ready(function() {
            // Iterasi melalui setiap elemen label yang memiliki data-asset-id
            $('label[data-asset-id]').each(function() {
                var label = $(this);
                var assetId = label.data('asset-id');
                const token = '{{ session()->get('api_token') }}';
                console.log(token);
                console.log(assetId);
                // Lakukan permintaan AJAX untuk mendapatkan nama Asset berdasarkan asset_id
                $.ajax({
                    url: 'http://logistik-api.test/api/v1/assets/' + assetId,
                    method: 'GET',
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    success: function(response) {
                        // Ganti teks label dengan nama Asset dari respon API
                        console.log(response.data.name);

                        label.text(response
                            .data.name
                        ); // Pastikan response.name sesuai dengan struktur data yang dikembalikan oleh API
                    },
                    error: function(xhr, status, error) {
                        // Tangani error jika permintaan gagal
                        console.error('Error fetching asset name:', error);
                        label.text('Error loading asset name');
                    }
                });
            });
        });
    </script>
@endpush
