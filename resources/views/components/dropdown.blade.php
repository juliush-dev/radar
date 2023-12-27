@props(['width' => '48'])

<x-splade-dropdown {{ $attributes->except('width') }}>
    <x-slot:trigger>
        {{ $trigger }}
    </x-slot:trigger>

    <div
        class="mt-2 {{ "w-{$width}" }} rounded-md shadow-lg ring-1 ring-black ring-opacity-5 py-1 bg-slate-100 dark:bg-slate-950 dark:shadow-slate-900 border border-slate-400/20">
        {{ $content }}
    </div>
</x-splade-dropdown>
