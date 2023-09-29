<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="referrer" content="no-referrer" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200;0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;0,6..12,900;0,6..12,1000;1,6..12,200;1,6..12,300;1,6..12,400;1,6..12,500;1,6..12,600;1,6..12,700;1,6..12,800;1,6..12,900;1,6..12,1000&display=swap"
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

        #hero,
        #auth-card {
            background-image: url('https://cdn.pixabay.com/photo/2016/09/23/11/05/feather-1689331_1280.png');
            /* background-repeat: ; */
        }

        #topic {
            /* background-image: rgba(255, 255, 255, 0.9), url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative; */
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
