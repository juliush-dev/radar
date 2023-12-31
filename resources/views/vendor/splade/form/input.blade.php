@php $flatpickrOptions = $flatpickrOptions() @endphp

<SpladeInput {{ $attributes->only(['v-if', 'v-show', 'v-for', 'class'])->class(['hidden' => $isHidden()]) }}
    :flatpickr="@js($flatpickrOptions)" :js-flatpickr-options="{!! $jsFlatpickrOptions !!}" v-model="{{ $vueModel() }}"
    #default="inputScope">
    <label class="block">
        @includeWhen($label, 'splade::form.label', ['label' => $label])

        <div class="flex rounded-none-md shadow-sm">
            @if ($prepend)
                <span :class="{ 'opacity-25': inputScope.disabled && @json(!$alwaysEnablePrepend) }"
                    class="inline-flex items-center px-3">
                    {!! $prepend !!}
                </span>
            @endif

            <input
                {{ $attributes->except(['v-if', 'v-show', 'v-for', 'class'])->class([
                        'block w-full border border-slate-300 rounded-none disabled:opacity-50 disabled:bg-slate-50 disabled:cursor-not-allowed bg-transparent',
                        'rounded-none' => !$append && !$prepend,
                        'min-w-0 flex-1 rounded-none' => $append || $prepend,
                        'rounded-none' => $append && !$prepend,
                        'rounded-none' => !$append && $prepend,
                    ])->merge([
                        'name' => $name,
                        'type' => $type,
                        'data-validation-key' => $validationKey(),
                    ])->when(
                        !$flatpickrOptions,
                        fn($attributes) => $attributes->merge([
                            'v-model' => $vueModel(),
                        ]),
                    ) }} />

            @if ($append)
                <span :class="{ 'opacity-50': inputScope.disabled && @json(!$alwaysEnableAppend) }"
                    class="inline-flex items-center px-3 rounded-none-r-md border border-t-0 border-b-0 border-r-0">
                    {!! $append !!}
                </span>
            @endif
        </div>
    </label>

    @include('splade::form.help', ['help' => $help])
    @includeWhen($showErrors, 'splade::form.error', ['name' => $validationKey()])
</SpladeInput>
