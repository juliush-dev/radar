<div {{ $attributes->only(['v-if', 'v-show', 'class']) }}>
    <label class="flex items-center text-slate-400">
        <input
            {{ $attributes->except(['v-if', 'v-show', 'class'])->class(
                    'bg-slate-800 border-emerald-500 rounded-full border-teal-500 text-teal-600 shadow-sm focus:border-teal-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 disabled:opacity-50',
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
