<SpladeTextarea {{ $attributes->only(['v-if', 'v-show', 'class']) }} :autosize="@js($attributes->has('autosize') ? (bool) $attributes->get('autosize') : $defaultAutosizeValue)"
    v-model="{{ $vueModel() }}">
    <label class="block">
        @includeWhen($label, 'splade::form.label', ['label' => $label])

        <textarea
            {{ $attributes->except(['v-if', 'v-show', 'class', 'autosize'])->class(
                    'block w-full rounded-none border-fuchsia-500 shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200 focus:ring-opacity-50 disabled:border-slate-300 disabled:border-4 bg-transparent',
                )->merge([
                    'name' => $name,
                    'v-model' => $vueModel(),
                    'data-validation-key' => $validationKey(),
                ]) }}></textarea>
    </label>

    @includeWhen($help, 'splade::form.help', ['help' => $help])
    @includeWhen($showErrors, 'splade::form.error', ['name' => $validationKey()])
</SpladeTextarea>
