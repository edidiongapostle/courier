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
    <body class="bg-gray-100 min-h-screen flex flex-col">
        @include('layouts.navigation')
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg flex-1">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </div>
        <footer class="bg-gray-800 text-gray-200 py-8 mt-12">
            <div class="container w-full max-w-full mx-auto px-4 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <div class="mb-4 md:mb-0 text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} SWIFT SYNCH. All rights reserved.
                </div>
                <div class="flex flex-wrap justify-center md:justify-end space-x-6 text-sm">
                    <a href="{{ route('fraud-awareness') }}" class="hover:underline">Fraud Awareness</a>
                    <a href="{{ route('legal-notice') }}" class="hover:underline">Legal Notice</a>
                    <a href="{{ route('terms-of-use') }}" class="hover:underline">Terms of Use</a>
                    <a href="{{ route('privacy-notice') }}" class="hover:underline">Privacy Notice</a>
                    <a href="{{ route('accessibility') }}" class="hover:underline">Accessibility</a>
                </div>
            </div>
        </footer>
    </body>
</html>
