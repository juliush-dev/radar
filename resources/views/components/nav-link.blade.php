@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? ' bg-fuchsia-200 hover:bg-fuchsia-300 text-fuchsia-900 dark:bg-fuchsia-900 dark:hover:bg-fuchsia-800 dark:text-fuchsia-200 font-medium shadow dark:shadow-slate-500 hover:shadow-xs ' : '';
    $classes .= ' py-1 px-3 first-letter:uppercase rounded-full inline-flex items.center justify.center gap-2 transition duration-500 ease-in-out';
@endphp

<{{ $as }} {{ $attributes->class($classes) }} @click.stop>
    {{ $slot }}
    </{{ $as }}>
