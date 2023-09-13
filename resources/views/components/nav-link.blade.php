@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? 'text-teal-600 underline underline-offset-2' : 'text-slate-800';
    $classes .= $active == true && $type == 'call-to-action' ? ' bg-green-700 text-white' : '';
    $classes .= $type == 'call-to-action' ? ' text-white bg-teal-500 border border-teal-500 p-2 rounded-sm text-sm hover:bg-green-500 shadow-sm shadow-teal-500' : ' hover:text-green-500';
    $classes .= ' rounded-sm inline-flex items.center justify.center gap-2 capitalize leading-5 focus:text-teal-600 transition duration-500 ease-in-out';
    $classes .= $small ?? false ? ' text-sm' : '';
@endphp

<{{ $as }} {{ $attributes->class($classes) }}>
    {{ $slot }}
    </{{ $as }}>
