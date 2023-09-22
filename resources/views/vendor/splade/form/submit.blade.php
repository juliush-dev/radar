@php $customStyling = $hasCustomStyling($attributes) @endphp

<div @class($wrapperClass)>
    <button
        {{ $attributes->class([
                'rounded-sm w-full border-0 bg-teal-500  text-white shadow-sm font-normal py-1 px-4 transition-colors',
                'hover:bg-teal-600' => !$customStyling && $primary,
                'bg-red-500 hover:bg-red-700 text-white border-transparent focus:border-red-700 focus:ring-red-200' =>
                    !$customStyling && $danger,
                'bg-white hover:bg-teal-100 text-teal-700 border-teal-500 focus:border-teal-500 focus:ring-teal-200' =>
                    !$customStyling && $secondary,
            ])->merge([
                'type' => $type,
            ])->when($name, fn($attr) => $attr->merge(['name' => $name, 'value' => $value])) }}>
        @if (trim($slot))
            {{ $slot }}
        @else
            <div class="flex flex-row items-center justify-center">
                <svg v-if="@js($spinner) && form.processing"
                    class="animate-spin mr-3 h-5 w-5 @if ($secondary) text-teal-700 @endif"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4" />
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                </svg>

                <span :class="{ 'opacity-50': form.processing || form.$uploading }">
                    {{ $label }}
                </span>
            </div>
        @endif
    </button>
</div>
