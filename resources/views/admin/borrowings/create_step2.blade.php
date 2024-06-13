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
            max-height: 400px;
            /* overflow: hidden; */
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
        <form action="{{ route('borrowing.store.step2') }}" method="POST">
            @csrf

            <div id="asset-section">
                @php
                    $assets = old('assets', $borrowingStep2['assets'] ?? []);
                @endphp
                @if ($assets)
                    @foreach ($assets as $index => $asset)
                        <div class="asset-item mb-5">
                            <div class="mb-5">
                                <label for="asset_id_{{ $index }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Asset
                                </label>
                                <div class="dropdown w-full">
                                    <input type="text" name="assets[{{ $index }}][asset_search]"
                                        onkeyup="filterFunction(this)"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Search for Asset" value="{{ $asset['asset_search'] ?? '' }}" />
                                    <input type="hidden" name="assets[{{ $index }}][asset_id]"
                                        value="{{ $asset['asset_id'] ?? '' }}" />
                                    <div class="dropdown-content" id="asset-dropdown-{{ $index }}">
                                        <!-- Dynamic options will be inserted here -->
                                    </div>
                                </div>
                                @error("assets.{$index}.asset_id")
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="start_date_{{ $index }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Start Date
                                </label>
                                <input type="datetime-local" name="assets[{{ $index }}][start_date]"
                                    id="start_date_{{ $index }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $asset['start_date'] ?? '' }}" />
                                @error("assets.{$index}.start_date")
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="end_date_{{ $index }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    End Date
                                </label>
                                <input type="datetime-local" name="assets[{{ $index }}][end_date]"
                                    id="end_date_{{ $index }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $asset['end_date'] ?? '' }}" />
                                @error("assets.{$index}.end_date")
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="description_{{ $index }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Description
                                </label>
                                <textarea name="assets[{{ $index }}][description]" id="description_{{ $index }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Description">{{ $asset['description'] ?? '' }}</textarea>
                                @error("assets.{$index}.description")
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="num_{{ $index }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Number of Assets
                                </label>
                                <input type="number" name="assets[{{ $index }}][num]" id="num_{{ $index }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Number of Assets" value="{{ $asset['num'] ?? '' }}" />
                                @error("assets.{$index}.num")
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="button" class="remove-asset text-red-600 dark:text-red-500 hover:underline">
                                Remove
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="asset-item mb-5">
                        <div class="mb-5">
                            <label for="asset_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Asset
                            </label>
                            <div class="dropdown w-full">
                                <input type="text" name="assets[0][asset_search]" onkeyup="filterFunction(this)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Search for Asset" />
                                <input type="hidden" name="assets[0][asset_id]" />
                                <div class="dropdown-content" id="asset-dropdown-0">
                                    <!-- Dynamic options will be inserted here -->
                                </div>
                                @error('assets.0.asset_id')
                                    <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Start Date
                            </label>
                            <input type="datetime-local" name="assets[0][start_date]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ old('assets.0.start_date') }}" />
                            @error('assets.0.start_date')
                                <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                End Date
                            </label>
                            <input type="datetime-local" name="assets[0][end_date]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Description
                            </label>
                            <textarea name="assets[0][description]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Description"></textarea>
                        </div>

                        <div class="mb-5">
                            <label for="num" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Number of Assets
                            </label>
                            <input type="number" name="assets[0][num]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Number of Assets" />
                        </div>

                        <button type="button" class="remove-asset text-red-600 dark:text-red-500 hover:underline">
                            Remove
                        </button>
                    </div>
                @endif
            </div>

            <a type="button" href="{{ route('borrowings.create.step1') }}"
                class="text-white bg-red-600 hover:bg-red-700 focus:ring-4  focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 me-1 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                Back
            </a>
            <button type="button" id="add-asset"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Add Another Asset
            </button>

            <button type="submit"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Submit
            </button>
        </form>

    </main>
@endsection

@push('scripts')
    <script>
        let assetIndex = 1;
        document.getElementById('add-asset').addEventListener('click', function() {
            const assetSection = document.getElementById('asset-section');
            const assetCount = assetSection.getElementsByClassName('asset-item').length;
            const newAsset = document.createElement('div');
            newAsset.className = 'asset-item mb-5';
            newAsset.innerHTML = `
                <div class="mb-5">
                    <label for="asset_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asset</label>
                    <div class ="dropdown w-full">
                        <input type="text" name="assets[${assetCount}][asset_search]" onkeyup="filterFunction(this)"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for Asset" />
                        <input type="hidden" name="assets[${assetCount}][asset_id]" />
                        <div class="dropdown-content" id="asset-dropdown-${assetCount}">
                            <!-- Dynamic options will be inserted here -->
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                    <input type="datetime-local" name="assets[${assetCount}][start_date]"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="mb-5">
                    <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                    <input type="datetime-local" name="assets[${assetCount}][end_date]"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea name="assets[${assetCount}][description]"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Description"></textarea>
                </div>
                <div class="mb-5">
                    <label for="num" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Assets</label>
                    <input type="number" name="assets[${assetCount}][num]"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Number of Assets" />
                </div>
                <button type="button" class="remove-asset text-red-600 dark:text-red-500 hover:underline">Remove</button>
            `;
            assetSection.appendChild(newAsset);

            // Add event listener for the new remove button
            newAsset.querySelector('.remove-asset').addEventListener('click', function() {
                newAsset.remove();
            });

            assetIndex++;
        });

        document.querySelectorAll('.remove-asset').forEach(function(button) {
            button.addEventListener('click', function() {
                button.closest('.asset-item').remove();
            });
        });

        let allAssets = [];

        async function fetchAssets() {
            const bearerToken = "{{ Session::get('api_token') }}";
            const baseUrl = "{{ config('services.api.base_url') }}";
            console.log(baseUrl);
            const response = await fetch(`${baseUrl}assets/all-asset`, {
                headers: {
                    'Authorization': `Bearer ${bearerToken}`
                }
            });
            const data = await response.json();
            allAssets = data.data;
            console.log(allAssets);
        }

        function filterFunction(inputElement) {
            const filter = inputElement.value.toLowerCase();
            const index = inputElement.name.match(/\d+/)[0];
            const dropdown = document.getElementById(`asset-dropdown-${index}`);

            dropdown.innerHTML = '';
            const filteredAssets = allAssets.filter(asset => asset.name.toLowerCase().includes(filter));
            filteredAssets.forEach(asset => {
                const div = document.createElement('div');
                div.textContent = asset.name;
                div.onclick = function() {
                    inputElement.value = asset.name;
                    inputElement.nextElementSibling.value = asset.id; // Menyimpan ID aset ke input tersembunyi
                    dropdown.innerHTML = '';
                };
                dropdown.appendChild(div);
            });
        }

        function showAllStudents(inputElement) {
            const filter = inputElement.value.toLowerCase();
            const index = inputElement.name.match(/\d+/)[0];
            const dropdown = document.getElementById(`asset-dropdown-${index}`);
            dropdown.innerHTML = '';
            allAssets.forEach(asset => {
                const div = document.createElement('div');
                div.textContent = asset.name;
                div.onclick = function() {
                    inputElement.value = asset.name;
                    document.getElementById('asset_id').value = asset.id;
                    dropdown.innerHTML = '';
                };
                dropdown.appendChild(div);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchAssets();
        });
    </script>
@endpush
