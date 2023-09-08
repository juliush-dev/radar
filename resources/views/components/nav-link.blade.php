@props(['active', 'as' => 'Link', 'type', 'small'])

@php
    $type = $type ?? 'default';
    $active = $active ?? false;
    $classes = $active ? 'text-teal-400' : 'text-slate-400';
    $classes .= $active == true && $type == 'call-to-action' ? ' bg-teal-700 text-white' : '';
    $classes .= $type == 'call-to-action' ? ' border border-teal-300 p-2 rounded-sm text-sm hover:bg-teal-400 focus:text-white hover:text-black shadow-md shadow-teal-500/60' : ' underline underline-offset-2';
    $classes .= ' rounded-sm inline-flex items.center justify.center gap-2 capitalize leading-5 focus:text-teal-400 hover:text-teal-400 transition duration-500 ease-in-out';
    $classes .= $small ?? false ? ' text-sm' : '';
@endphp

<{{ $as }} {{ $attributes->class($classes) }}>
    {{ $slot }}
    </{{ $as }}>
