<x-layouts.main-content>
    <h1 class="text-3xl flex gap-2 items.center capitalize flex-nowrap">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-10 h-10">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="{{ strlen($actionIcon) > 0 ? $actionIcon : 'M12 6v12m6-6H6' }}" />
        </svg>
        <span>{{ $label }}</span>
    </h1>
    <Link href="/" class="pl-2 underline underline-offset-2">Back to landing page</Link>
    <div class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-6 pr-6 pb-6 pt-3 pl-2 relative">
        {{ $slot }}
    </div>
</x-layouts.main-content>
