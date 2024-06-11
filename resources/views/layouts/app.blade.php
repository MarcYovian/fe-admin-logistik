<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $url }} | Logistik</title>

    {{-- Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    @vite('resources/css/app.css')

    @stack('style')

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <div class="flex">
        @include('partials.sidebar')
        <div class=" flex h-screen flex-1 flex-col overflow-y-auto overflow-x-hidden bg-gray-300 dark:bg-gray-900">
            @include('partials.headers')
            @yield('content')
        </div>

        @stack('scripts')
</body>

</html>
