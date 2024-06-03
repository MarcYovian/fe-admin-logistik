<aside class=" h-screen w-72 overflow-hidden z-[99999] bg-black duration-300 ease-linear">
    <div class="flex flex-col">

        {{-- SIDEBAR HEADER --}}
        <div class="flex items-center justify-between gap-2 px-6 py-5 lg:py-6">
            <a class="text-white col-md-3 me-0 px-3 text-2xl font-bold" href="#">LOGISTIC</a>
        </div>

        {{-- SIDEBAR HEADER --}}
        <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
            <nav class="mt-5 px-4 py-4 lg:px-6">
                <div>
                    <h3 class="mb-4 ml-4 text-sm font-medium text-slate-500">MENU</h3>

                    <ul class="mb-6 flex flex-col gap-2">
                        {{-- MENU DASHBOARD --}}
                        <li>
                            <a class="group relative flex items-center gap-2 rounded-sm px-4 py-2 font-medium text-slate-300 duration-300 ease-in-out hover:bg-gray-400 dark:hover:bg-meta-4 @if ($active == 'dashboard') bg-gray-400 @endif"
                                href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        {{-- MENU ASSET --}}
                        <li>
                            <a class="group relative flex items-center gap-2 rounded-sm px-4 py-2 font-medium text-slate-300 duration-300 ease-in-out hover:bg-gray-400 dark:hover:bg-meta-4 @if ($active == 'assets') bg-gray-400 @endif"
                                href="{{ route('assets.index') }}">Assets</a>
                        </li>
                        {{-- MENU borrowing --}}
                        <li>
                            <a class="group relative flex items-center gap-2 rounded-sm px-4 py-2 font-medium text-slate-300 duration-300 ease-in-out hover:bg-gray-400 dark:hover:bg-meta-4 @if ($active == 'borrowings') bg-gray-400 @endif"
                                href="{{ route('borrowings.index') }}">Peminjaman</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 ml-4 text-sm font-medium text-slate-500">OTHERS</h3>

                    <ul class="mb-6 flex flex-col gap-2">
                        {{-- MENU DASHBOARD --}}
                        <li>
                            <a class="group relative flex items-center gap-2 rounded-sm px-4 py-2 font-medium text-slate-300 duration-300 ease-in-out hover:bg-gray-400 dark:hover:bg-meta-4 @if ($active == 'settings') bg-gray-400 @endif"
                                href="#">Settings</a>
                        </li>
                        {{-- MENU ASSET --}}
                        <li>
                            <a class="group relative flex items-center gap-2 rounded-sm px-4 py-2 font-medium text-slate-300 duration-300 ease-in-out hover:bg-gray-400 dark:hover:bg-meta-4"
                                href="{{ route('logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</aside>
