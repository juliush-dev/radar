@props(['as' => 'Link'])

<{{ $as }}
    {{ $attributes->class('block px-4 py-2 text-sm leading-5 text-green-700 hover:bg-green-100 focus:outline-none focus:bg-green-100 transition duration-150 ease-in-out') }}>
    {{ $slot }}</{{ $as }}>
