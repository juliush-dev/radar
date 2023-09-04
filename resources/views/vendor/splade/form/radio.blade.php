<div {{ $attributes->only(['v-if', 'v-show', 'class']) }}>
    <label class="flex items-center">
        <input
            {{ $attributes->except(['v-if', 'v-show', 'class'])->class(
                    'bg-slate-800 border-teal-500 rounded-full border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50 disabled:opacity-50',
                )->merge([
                    'name' => $name,
                    'value' => $value,
                    'type' => 'radio',
                    'v-model' => $vueModel(),
                    'data-validation-key' => $validationKey(),
                ]) }} />

        @if (trim($slot))
            <span class="ml-2">{{ $slot }}</span>
        @else
            <span class="ml-2">{{ $label }}</span>
        @endif
    </label>

    @includeWhen($help, 'splade::form.help', ['help' => $help])
    @includeWhen($showErrors, 'splade::form.error', ['name' => $validationKey()])
</div>
