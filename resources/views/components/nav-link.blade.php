@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? 'text-teal-600 underline underline-offset-2' : 'text-slate-800';
    $classes .= $active == true && $type == 'call-to-action' ? ' bg-teal-600' : '';
    $classes .= $type == 'call-to-action' ? ' text-white bg-teal-500 p-2  text-sm hover:bg-teal-600 shadow-md hover:shadow-xl' : ' hover:text-teal-500  underline underline-offset-2';
    $classes .= ' whitespace-nowrap rounded-sm inline-flex items.center justify.center gap-2 capitalize leading-5 transition duration-500 ease-in-out';
    $classes .= $small ?? false ? ' text-xs' : '';
@endphp

<{{ $as }} {{ $attributes->class($classes) }}>
    {{ $slot }}
    </{{ $as }}>
