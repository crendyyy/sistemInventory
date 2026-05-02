<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem RPC') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100 flex min-h-screen">
    
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
        <!-- Topbar -->
        @include('layouts.topbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="mb-6">
                        {{ $header }}
                    </header>
                @endif
                
                {{ $slot }}
            </div>
        </main>
        <script>
            document.addEventListener('input', function (e) {
                if (e.target.classList.contains('input-number')) {
                    let cursorPosition = e.target.selectionStart;
                    let originalLength = e.target.value.length;
                    
                    let value = e.target.value.replace(/[^0-9]/g, '');
                    
                    if (value !== '') {
                        e.target.value = new Intl.NumberFormat('id-ID').format(value);
                    } else {
                        e.target.value = '';
                    }
                    
                    let newLength = e.target.value.length;
                    cursorPosition = cursorPosition + (newLength - originalLength);
                    e.target.setSelectionRange(cursorPosition, cursorPosition);
                }
            });

            document.addEventListener('submit', function(e) {
                let inputs = e.target.querySelectorAll('.input-number');
                inputs.forEach(input => {
                    input.value = input.value.replace(/\./g, '');
                });
            });
        </script>
    </div>
</body>
</html>
