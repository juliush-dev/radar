@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? ' underline underline-offset-2' : '';
    $classes .= ' first-letter:uppercase rounded-sm inline-flex items.center justify.center gap-2 transition duration-500 ease-in-out';
@endphp

<{{ $as }} {{ $attributes->class($classes) }} @click.stop>
    {{ $slot }}
    </{{ $as }}>
