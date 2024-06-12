<header
    class="z-[999] sticky top-0 flex w-full bg-white dark:bg-gray-800 drop-shadow-1 dark:shadow-white dark:shadow-sm">
    <div class="flex flex-grow items-center justify-end px-4 py-4 shadow-2 md:px-6 2xl:px-11">

        <div class="flex items-center gap-3 2xsm:gap-7">
            <!-- User Area -->
            <div class="relative">
                <button class="flex items-center gap-4" id="openModal">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-black dark:text-white">{{ $admin['name'] }}</span>
                        <span class="block text-xs font-medium text-gray-600 dark:text-gray-400">admin
                            {{ $admin['type'] }}</span>
                    </span>

                    <span class="h-12 w-12 rounded-full">
                        <img class=" h-12 w-12 rounded-full object-cover"
                            src="{{ Vite::asset('resources/images/pas foto.jpg') }}" alt="User">
                    </span>
                </button>
            </div>
            <!-- User Area -->
        </div>
    </div>
</header>
{{-- HEADER END --}}
<!-- Modal -->
<div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">User Information</h2>
        <div id="userInfo" class="mb-4">
            <!-- User information will be displayed here -->
        </div>
        <button id="closeModal" class="px-4 py-2 bg-red-500 text-white rounded">Close</button>
    </div>
</div>
<script>
    document.getElementById("openModal").addEventListener("click", function() {
        // Example data
        const userData = {
            id: {{ $admin['id'] }},
            name: "{{ $admin['name'] }}",
            email: "{{ $admin['email'] }}",
            username: "{{ $admin['username'] }}",
            type: "{{ $admin['type'] }}",
            is_active: {{ $admin['is_active'] }},
            token: "{{ $admin['token'] }}"
        };

        // Populate modal with user data
        const userInfoDiv = document.getElementById("userInfo");
        userInfoDiv.innerHTML = `
                <p><strong>ID:</strong> ${userData.id}</p>
                <p><strong>Name:</strong> ${userData.name}</p>
                <p><strong>Email:</strong> ${userData.email}</p>
                <p><strong>Username:</strong> ${userData.username}</p>
                <p><strong>Type:</strong> ${userData.type}</p>
                <p><strong>Active:</strong> ${userData.is_active ? 'Yes' : 'No'}</p>
                <p><strong>Token:</strong> ${userData.token}</p>
            `;

        // Show modal
        document.getElementById("modal").classList.remove("hidden");
    });

    document.getElementById("closeModal").addEventListener("click", function() {
        // Hide modal
        document.getElementById("modal").classList.add("hidden");
    });
</script>
</script>
