<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        * {
            --sb-track-color: #f1f5f7;
            --sb-thumb-color: #cccccc;
            --sb-size: 5px;
            scrollbar-color: var(--sb-thumb-color) var(--sb-track-color);
        }

        *::-webkit-scrollbar {
            width: var(--sb-size);
            height: var(--sb-size);
        }

        *::-webkit-scrollbar-track {
            background: var(--sb-track-color);
            border-radius: 5px;
        }

        *::-webkit-scrollbar-thumb {
            background: var(--sb-thumb-color);
            border-radius: 10px;

        }

        * {
            font-family: 'Inter', sans-serif;
        }

        #hero {
            background-image: url('https://cdn.pixabay.com/photo/2016/09/23/11/05/feather-1689331_1280.png');
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @spladeHead
</head>

<body @preserveScroll('mainView') class="font-sans antialiased h-screen">
    @splade
</body>

</html>
