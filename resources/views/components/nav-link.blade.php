@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? ' py-1 px-2 bg-fuchsia-200 text-fuchsia-900 dark:bg-fuchsia-900 dark:text-fuchsia-200 font-medium' : '';
    $classes .= ' first-letter:uppercase rounded-full inline-flex items.center justify.center gap-2 transition duration-500 ease-in-out';
@endphp

<{{ $as }} {{ $attributes->class($classes) }} @click.stop>
    {{ $slot }}
    </{{ $as }}>
