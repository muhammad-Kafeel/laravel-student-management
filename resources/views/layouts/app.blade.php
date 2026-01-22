<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

    @if (isset($header))
        <header class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-8">
                    
                    <h2 class="flex-shrink-0 font-bold text-2xl text-gray-800 tracking-tight">
                        {{ $header }}
                    </h2>

                    <div class="flex-grow max-w-xl">
                        <form action="search" method="GET" class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            
                            <input type="text" 
                                name="search" 
                                placeholder="Search student..." 
                                class="block w-full pl-10 pr-24 py-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm"
                            >

                            <button type="submit" 
                                    class=" text-gray-100 pl-10 pr-24 py-2.5 px-4 bg-dark-900 hover:bg-indigo-700 text-black text-sm font-semibold rounded-md transition-colors duration-200 shadow-md border border-gray-300 rounded-lg bg-gray-50">
                                Search
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </header>
    @endif
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
