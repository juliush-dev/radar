@php $customStyling = $hasCustomStyling($attributes) @endphp

<SpladeButton {{ $attributes->only(['v-bind:spinner', ':spinner']) }}>
    <template #default="button">
        <{{ $type === 'link' ? 'Link' : 'button' }} :disabled="button.spinner"
            {{ $attributes->class([
                    'rounded-sm border border-teal-300 outline outline-1 p-2 text-sm inline-flex items.center justify.center gap-2 first-letter:capitalize leading-5 focus:text-teal-400 hover:text-teal-400 shadow-md shadow-teal-500/60 transition duration-500 ease-in-out',
                    ' hover:bg-teal-700 text-teal-400 border-0 hover:text-teal-200 focus:ring-teal-400' =>
                        !$customStyling && $primary,
                    'bg-red-500 hover:bg-red-700 text-white border-transparent focus:border-red-700 focus:ring-red-200' =>
                        !$customStyling && $danger,
                    'bg-white hover:bg-gray-100 text-gray-700 border-gray-300 focus:border-indigo-300 focus:ring-indigo-200' =>
                        !$customStyling && $secondary,
                ])->except(['v-bind:spinner', ':spinner'])->merge(['type' => $type])->when($name, fn($attr) => $attr->merge(['name' => $name, 'value' => $value])) }}>
            @if (trim($slot))
                {{ $slot }}
            @else
                <div class="flex flex-row items-center justify-center">
                    <svg v-if="button.spinner"
                        class="animate-spin mr-3 h-5 w-5 @if ($secondary) text-gray-700 @endif"
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
            </{{ $type === 'link' ? 'Link' : 'button' }}>
    </template>
</SpladeButton>
