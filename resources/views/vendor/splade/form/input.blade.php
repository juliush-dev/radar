@php $flatpickrOptions = $flatpickrOptions() @endphp

<SpladeInput {{ $attributes->only(['v-if', 'v-show', 'v-for', 'class'])->class(['hidden' => $isHidden()]) }}
    :flatpickr="@js($flatpickrOptions)" :js-flatpickr-options="{!! $jsFlatpickrOptions !!}" v-model="{{ $vueModel() }}"
    #default="inputScope">
    <label class="block">
        @includeWhen($label, 'splade::form.label', ['label' => $label])

        <div class="flex rounded-md shadow-sm">
            @if ($prepend)
                <span :class="{ 'opacity-25': inputScope.disabled && @json(!$alwaysEnablePrepend) }"
                    class="inline-flex items-center px-3">
                    {!! $prepend !!}
                </span>
            @endif

            <input
                {{ $attributes->except(['v-if', 'v-show', 'v-for', 'class'])->class([
                        'bg-slate-100 block w-full border-0  disabled:opacity-50 disabled:bg-slate-50 disabled:cursor-not-allowed',
                        'rounded' => !$append && !$prepend,
                        'min-w-0 flex-1 rounded-none' => $append || $prepend,
                        'rounded' => $append && !$prepend,
                        'rounded' => !$append && $prepend,
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
                    class="inline-flex items-center px-3 rounded-r-md border border-t-0 border-b-0 border-r-0">
                    {!! $append !!}
                </span>
            @endif
        </div>
    </label>

    @include('splade::form.help', ['help' => $help])
    @includeWhen($showErrors, 'splade::form.error', ['name' => $validationKey()])
</SpladeInput>
