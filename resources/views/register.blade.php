<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    <!-- component -->
    <div class="bg-white flex justify-center items-center h-screen">
        <!-- Left: Image -->
        <div class="w-1/2 h-screen hidden lg:block p-24">
            <img src="{{ Vite::asset('resources/images/login-image.png') }}" alt="Placeholder Image"
                class="object-cover w-full h-full">
        </div>
        <!-- Right: Login Form -->
        <div class="lg:p-52 md:p-60 sm:20 p-8 w-full lg:w-1/2">
            <h1 class="text-3xl font-semibold mb-4 text-violet-900">Join with us</h1>
            <form action="{{ route('postRegister') }}" method="POST">
                @csrf

                {{-- Error Message --}}
                @if ($errors->has('message'))
                    <div class="flex items-center p-4 mb-4 text-sm text-violet-900 rounded-lg bg-red-50" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <!-- name Input -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-600 mb-2">Username</label>
                    <input type="text" id="username" name="username"
                        class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-violet-300 bg-white text-gray-800"
                        autocomplete="off">
                    @error('username')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <!-- name Input -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-600 mb-2">name</label>
                    <input type="text" id="name" name="name"
                        class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-violet-300 bg-white text-gray-800"
                        autocomplete="off">
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 mb-2">email</label>
                    <input type="email" id="email" name="email"
                        class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-violet-300 bg-white text-gray-800"
                        autocomplete="off">
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-600 mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border rounded-md py-2 px-3 focus:outline-none focus:border-violet-300 text-gray-800"
                        autocomplete="off">
                </div>
                <div class="flex justify-between w-full">
                    <!-- Remember Me Checkbox -->
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="text-blue-500">
                        <label for="remember" class="text-violet-900 ml-2">Remember Me</label>
                    </div>

                </div>
                <!-- Login Button -->
                <button type="submit"
                    class="bg-violet-900 hover:bg-violet-800 text-white font-semibold rounded-md py-2 px-4 w-full">Login</button>
            </form>
            <!-- Sign up  Link -->
            <div class="mt-6 text-violet-400 text-center">
                <a href="{{ route('login') }}" class="hover:underline">have an account? sign-in Here</a>
            </div>
        </div>
    </div>
</body>

</html>
