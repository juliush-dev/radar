@php $customStyling = $hasCustomStyling($attributes) @endphp

<SpladeButton {{ $attributes->only(['v-bind:spinner', ':spinner']) }}>
    <template #default="button">
        <{{ $type === 'link' || $type === 'call-to-action-link' ? 'Link' : 'button' }} :disabled="button.spinner"
            {{ $attributes->class([
                    'p-2 text-sm inline-flex items.center justify.center gap-2 first-letter:capitalize leading-5 transition duration-500 ease-in-out',
                    'hover:bg-teal-200' => !$customStyling && $primary,
                    'text-white bg-teal-500 p-2 text-sm hover:bg-teal-600 shadow-md hover:shadow-xl' =>
                        $type === 'call-to-action' || $type == 'call-to-action-link',
                    'bg-red-500 hover:bg-red-700 text-white border-transparent focus:border-red-700 focus:ring-red-200' =>
                        !$customStyling && $danger,
                    'bg-white hover:bg-green-100 text-green-700 border-teal-500 focus:border-teal-500 focus:ring-emerald-200' =>
                        !$customStyling && $secondary,
                ])->except(['v-bind:spinner', ':spinner'])->merge(['type' => $type])->when($name, fn($attr) => $attr->merge(['name' => $name, 'value' => $value])) }}>
            @if (trim($slot))
                {{ $slot }}
            @else
                <div class="flex flex-row items-center justify-center">
                    <svg v-if="button.spinner"
                        class="animate-spin mr-3 h-5 w-5 @if ($secondary) text-teal-700 @endif"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                    </svg>

                    <span :class="{ 'opacity-50': button.spinner }">
                        {{ $label }}
                    </span>
                </div>
            @endif
            </{{ $type === 'link' || $type === 'call-to-action-link' ? 'Link' : 'button' }}>
    </template>
</SpladeButton>
