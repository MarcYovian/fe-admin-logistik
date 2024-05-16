<header
    class="z-[999] sticky top-0 flex w-full bg-white dark:bg-gray-800 drop-shadow-1 dark:shadow-white dark:shadow-sm">
    <div class="flex flex-grow items-center justify-end px-4 py-4 shadow-2 md:px-6 2xl:px-11">

        <div class="flex items-center gap-3 2xsm:gap-7">
            <!-- User Area -->
            <div class="relative">
                <a class="flex items-center gap-4" href="#">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-black dark:text-white">{{ $admin['name'] }}</span>
                        <span class="block text-xs font-medium text-gray-600 dark:text-gray-400">admin
                            {{ $admin['role'] }}</span>
                    </span>

                    <span class="h-12 w-12 rounded-full">
                        <img class=" h-12 w-12 rounded-full object-cover"
                            src="{{ Vite::asset('resources/images/pas foto.jpg') }}" alt="User">
                    </span>
                </a>
            </div>
            <!-- User Area -->
        </div>
    </div>
</header>
{{-- HEADER END --}}
