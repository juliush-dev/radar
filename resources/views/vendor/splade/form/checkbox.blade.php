<div {{ $attributes->only(['v-if', 'v-show']) }}>
    <label class="flex items-center">
        <input
            {{ $attributes->except(['v-if', 'v-show'])->class(
                    'rounded-sm border border-fuchsia-500 text-fuchsia-600 shadow-sm focus:border-fuchsia-500 focus:ring focus:ring-fuchsia-200 focus:ring-opacity-50 disabled:opacity-50',
                )->merge([
                    'name' => $name,
                    'value' => $value,
                    'type' => 'checkbox',
                    'v-model' => $vueModel(),
                    'data-validation-key' => $validationKey(),
                ]) }}
            :true-value="@js($value)" :false-value="@js($falseValue)" />

        @if (trim($slot))
            <span class="ml-2">{{ $slot }}</span>
        @else
            <span class="ml-2">{{ $label }}</span>
        @endif
    </label>

    @includeWhen($help, 'splade::form.help', ['help' => $help])
    @includeWhen($showErrors, 'splade::form.error', ['name' => $validationKey()])
</div>
