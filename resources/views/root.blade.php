<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <style>
        * {
            --sb-track-color: #232E33;
            --sb-thumb-color: amber;
            --sb-size: 10px;

            scrollbar-color: var(--sb-thumb-color) var(--sb-track-color);
        }

        *::-webkit-scrollbar {
            width: var(--sb-size)
        }

        *::-webkit-scrollbar-track {
            background: var(--sb-track-color);
            border-radius: 10px;
        }

        *::-webkit-scrollbar-thumb {
            background: var(--sb-thumb-color);
            border-radius: 10px;

        }
    </style>
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @spladeHead
</head>

<body class="font-sans antialiased h-screen flex flex-col">
    @splade
</body>

</html>
