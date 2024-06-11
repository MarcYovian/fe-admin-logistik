@extends('layouts.app')

@section('content')
    <main class="md:col-span-9 lg:col-span-10 md:px-4">
        <div class="flex justify-between flex-wrap md:flex-nowrap items-center pt-3 pb-2 mb-3 border-b dark:text-white">
            <h1 class="text-3xl font-bold">Dashboard</h1>
        </div>

        <div class="p-3 mb-2 bg-blue-400 text-white">
            <pre>{{ json_encode($admin, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </main>
@endsection
