@props(['active', 'as' => 'Link'])

@php
    $classes = $active ?? false ? 'block pl-3 pr-4 py-2 border-l-4 border-emerald-400 text-base font-medium text-green-700 bg-green-50 focus:outline-none focus:text-teal-600 focus:bg-green-100 focus:border-emerald-700 transition duration-150 ease-in-out' : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-teal-600 hover:text-teal-600 hover:bg-green-50 hover:border-teal-500 focus:outline-none focus:text-teal-600 focus:bg-green-50 focus:border-teal-500 transition duration-150 ease-in-out';
@endphp

<{{ $as }} {{ $attributes->class($classes) }}>
    {{ $slot }}
    </{{ $as }}>
