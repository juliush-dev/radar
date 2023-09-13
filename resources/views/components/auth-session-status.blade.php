<x-splade-flash>
    <div v-if="flash.has('status')" v-text="flash.status" {{ $attributes->class('font-medium text-sm text-teal-600') }} />
</x-splade-flash>
