<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Lara Messenger' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body>
    <div class="h-screen w-full flex antialiased text-gray-900 bg-gray-300 overflow-hidden">
        <div class="flex-1 flex flex-col">
        <livewire:layout.navigation />
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
    </body>
</html>
