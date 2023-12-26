@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? ' px-3 bg-fuchsia-200 hover:bg-fuchsia-300 text-fuchsia-900 dark:bg-fuchsia-800/40 dark:hover:bg-fuchsia-800/60 dark:text-fuchsia-400/70 font-medium shadow dark:shadow-slate-500/10 hover:shadow-xs ' : 'text-fuchsia-600 hover:text-fuchsia-700 dark:text-fuchsia-600/70 dark:hover:text-fuchsia-500 ';
    $classes .= ' py-1 first-letter:uppercase rounded-full inline-flex items.center justify.center gap-2 transition duration-500 ease-in-out';
@endphp

<{{ $as }} {{ $attributes->class($classes) }} @click.stop>
    {{ $slot }}
    </{{ $as }}>
