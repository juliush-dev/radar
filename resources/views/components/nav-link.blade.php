@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? ' underline underline-offset-2' : '';
    // $classes .= $type == 'call-to-action' ? ' text-white p-2  text-sm  shadow-md hover:shadow-xl' : '';
    $classes .= ' first-letter:uppercase whitespace-nowrap rounded-sm inline-flex items.center justify.center gap-2 leading-5 transition duration-500 ease-in-out';
    $classes .= $small ?? false ? ' text-xs' : '';
@endphp

<{{ $as }} {{ $attributes->class($classes) }}>
    {{ $slot }}
    </{{ $as }}>
