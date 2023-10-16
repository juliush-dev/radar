<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="referrer" content="no-referrer" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @spladeHead
</head>

<body @preserveScroll('mainView') class="antialiased relative flex flex-col">
    @splade
</body>

</html>
