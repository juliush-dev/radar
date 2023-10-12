<x-splade-component is="dropdown"
    {{ $attributes->class('w-full bg-white border border-fuchsia-500 shadow-sm px-2.5 sm:px-4 py-2 inline-flex justify-center text-sm font-medium text-green-700 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500') }}>
    <x-slot:trigger>
        {{ $button }}
    </x-slot:trigger>

    <div class="mt-2 min-w-max shadow-lg bg-white ring-1 ring-black ring-opacity-5">
        {{ $slot }}
    </div>
</x-splade-component>
