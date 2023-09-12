@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? 'text-amber-400' : 'text-slate-400';
    $classes .= $active == true && $type == 'call-to-action' ? ' bg-amber-700 text-white' : '';
    $classes .= $type == 'call-to-action' ? ' border border-amber-300 p-2 rounded-sm text-sm hover:bg-amber-400 focus:text-white hover:text-black shadow-md shadow-amber-500/60' : ' hover:text-amber-400 underline underline-offset-2';
    $classes .= ' rounded-sm inline-flex items.center justify.center gap-2 capitalize leading-5 focus:text-amber-400 transition duration-500 ease-in-out';
    $classes .= $small ?? false ? ' text-sm' : '';
@endphp

<{{ $as }} {{ $attributes->class($classes) }}>
    {{ $slot }}
    </{{ $as }}>
