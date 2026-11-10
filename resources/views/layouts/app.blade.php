<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body x-data>
    @auth
    <x-ui.navbar class="flex border border-gray-200 rounded-xl mt-4 mx-auto w-max flex-row items-center gap-4">
        <x-ui.navbar.item label="Home" href="/" />
        @can('admin')
        <x-ui.navbar.item label="Raffles" href="{{ route('admin.raffle') }}" />
        @endcan
        <x-ui.navbar.item label="Logout" href="{{ route('logout') }}" />
    </x-ui.navbar>
    @endauth

    <main class="p-5 mt-10 mx-auto max-w-xl">
        {{ $slot }}
    </main>


    @livewireScripts
</body>

</html>