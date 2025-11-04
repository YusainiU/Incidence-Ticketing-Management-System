<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @PwaHead <!-- PWA meta tags directive -->

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @filemanagerStyles   

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @if(Auth::check())
            @if(session('isCustomer') == 'true')
                @livewire('customer-navigation-menu')
            @else
	            @livewire('steps-navigation-menu')
               
            @endif
        @endif	
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        @livewire('steps-footer')
    </div>

    @livewire('wire-elements-modal')
    {{-- @stack('modals') --}}

    @livewireScripts
    @filemanagerScripts

    @RegisterServiceWorkerScript <!-- Service worker registration -->

</body>

</html>
