<x-layouts.main-content>
    <h1 class="text-3xl mb-5 flex gap-2 items.center capitalize">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-10 h-10">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="{{ strlen($actionIcon) > 0 ? $actionIcon : 'M12 6v12m6-6H6' }}" />
        </svg>
        {{ $label }}
    </h1>

    <div class="absolute bottom-0 right-0 p-8">
        <x-layouts.navigation-link :resource="'contribution.' . $type" :label="$actionLabel" open-as="slideover" action="create"
            type="call-to-action" iconPath="{{ strlen($actionIcon) > 0 ? $actionIcon : 'M12 6v12m6-6H6' }}" />
    </div>
    {{ $slot }}
</x-layouts.main-content>
