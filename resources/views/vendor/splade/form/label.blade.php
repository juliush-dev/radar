<span class="block mb-3 font-sans first-letter:uppercase text-lg dark:text-slate-100">
    {!! $label !!}
    @if ($attributes->has('required') || $attributes->has('data-required'))
        <span aria-hidden="true" class="text-red-500" title="{{ __('This field is required') }}">*</span>
    @endif
</span>
