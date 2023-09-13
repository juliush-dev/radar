<span class="block mb-3 text-slate-700 font-sans first-letter:uppercase">
    {!! $label !!}
    @if ($attributes->has('required') || $attributes->has('data-required'))
        <span aria-hidden="true" class="text-red-500" title="{{ __('This field is required') }}">*</span>
    @endif
</span>
