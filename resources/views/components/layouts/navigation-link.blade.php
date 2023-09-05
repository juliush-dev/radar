@php($isActive = request()->routeIs(empty($action) ? $resource : $resource . '.' . $action))
<x-splade-toggle data="childrenHidden">
    <div class="flex flex-col gap-2">
        <div class="flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 {{ $isActive ? 'text-teal-400' : '' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
            </svg>

            <x-nav-link :active="$isActive" :modal="$openAs == 'modal'" :slideover="$openAs == 'slideover'" :method="$post ? 'post' : ''" :href="route(empty($action) ? $resource : $resource . '.' . $action)">
                {{ $label }}
            </x-nav-link>


            @if (strlen($slot) > 0)
                <div v-show="childrenHidden == false">
                    <svg @click.prevent="setToggle('childrenHidden', true)" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
                <div v-show="childrenHidden == true">
                    <svg @click.prevent="setToggle('childrenHidden', false)" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            @endif
        </div>
        <x-splade-transition show="childrenHidden == true">
            <div class="flex flex-col gap-2 border-l pl-3 ml-2">
                {{ $slot }}
            </div>
        </x-splade-transition>
    </div>
</x-splade-toggle>
