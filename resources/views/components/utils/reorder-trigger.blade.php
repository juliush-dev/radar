<x-splade-toggle>
    <x-splade-transition animation="slide-left" enter="duration-300" show="{!! $showCancel !!}" class="flex gap-6">
        <button @click.prevent.stop="setToggle({!! $onCancel !!})" class="flex items-center w-fit gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.564A.562.562 0 019 14.437V9.564z" />
            </svg>
            <span>Cancel</span>
        </button>
    </x-splade-transition>
    <x-splade-transition animation="slide-left" enter="duration-300" show="{!! $showReference !!}">
        <button @click.prevent.stop="{!! $onReference !!}" class="flex items-center w-fit gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="first-letter:uppercase" v-text="{!! $position !!} + ' Me'"></span>
        </button>
    </x-splade-transition>
    <x-splade-transition animation="slide-left" enter="transition-opacity duration-75" show="{!! $showReorderPosition !!}"
        class="flex items-center gap-6 w-fit overflow-hidden">
        <button @click.prevent.stop="setToggle({!! $onReorderBefore !!})" class="w-fit flex items-center gap-1 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 text-xs">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
            </svg>
            Reorder before
        </button>
        <button @click.prevent.stop="setToggle({!! $onReorderAfter !!})" class="w-fit flex items-center gap-1 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 text-xs">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
            </svg>
            Reorder after
        </button>
    </x-splade-transition>
</x-splade-toggle>
