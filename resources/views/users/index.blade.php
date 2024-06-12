@extends('layouts.app')

@push('style')
    <style>
        .toggle-checkbox:checked {
            right: 0;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #4ade80;
            /* Green */
        }

        .toggle-checkbox {
            right: 16px;
            transition: right 0.2s ease-in-out;
        }
    </style>
@endpush

@section('content')
    <div class="bg-gray-100 p-8">
        <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="w-full bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold tracking-wider">
                        <th class="px-6 py-3 border-b">Name</th>
                        <th class="px-6 py-3 border-b">Email</th>
                        <th class="px-6 py-3 border-b">Username</th>
                        <th class="px-6 py-3 border-b">Active</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users['data'] as $user)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 border-b">{{ $user['name'] }}</td>
                            <td class="px-6 py-4 border-b">{{ $user['email'] }}</td>
                            <td class="px-6 py-4 border-b">{{ $user['username'] }}</td>
                            <td class="px-6 py-4 border-b">
                                <div
                                    class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input onchange="setIsActive(this)" type="checkbox" name="toggle"
                                        id="toogle{{ $user['id'] }}"
                                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                                        data-id="{{ $user['id'] }}" {{ $user['is_active'] ? 'checked' : '' }} />
                                    <label for="toggle{{ $user['id'] }}"
                                        class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function setIsActive(element) {
            console.log(element.id.replace("toogle", ""));
            console.log(element.checked);

            var adminId = element.id.replace("toogle", "");
            var isActive = element.checked;

            const token = '{{ session()->get('api_token') }}';

            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/admins/users/' + adminId + '/is-active',
                type: 'PUT',
                contentType: "application/json",
                headers: {
                    "Authorization": "Bearer " + token
                },
                data: JSON.stringify({
                    is_active: isActive,
                }),
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr);
                    if (xhr.status === 403) {
                        alert(xhr.responseJSON.errors.message[0]);
                    } else {
                        alert('An error occurred while updating the status.');
                    }
                    // Revert toggle state if there's an error
                    $(this).prop('checked', !isActive);
                }.bind(this)
            });
        }

        $(document).ready(function() {
            $('.toggle-is-active').change(function() {
                var adminId = $(this).data('id');
                var isActive = $(this).is(':checked') ? 1 : 0;

                const token = '{{ session()->get('api_token') }}';

                $.ajax({
                    url: 'http://127.0.0.1:8000/api/v1/admins/users/' + adminId + '/is-active',
                    type: 'PUT',
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    data: {
                        is_active: isActive,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log("asu");
                        if (xhr.status === 403) {
                            alert(xhr.responseJSON.errors.message[0]);
                        } else {
                            alert('An error occurred while updating the status.');
                        }
                        // Revert toggle state if there's an error
                        $(this).prop('checked', !isActive);
                    }.bind(this)
                });
            });
        });
    </script>
@endsection
