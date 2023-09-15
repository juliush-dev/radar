@php
    $routeName = empty($action) ? $resource : $resource . '.' . $action;
    $postActions = ['update', 'delete', 'store'];
    $method = in_array($action, $postActions) || $resource == 'logout' ? 'post' : 'get';
    $route = isset($actionArgs) ? route($routeName, $actionArgs) : ($route = route($routeName));
    $isActive = $type == 'call-to-action' ? false : request()->routeIs($routeName) || request()->url() == $route || str_starts_with(Route::currentRouteName(), $resource);
@endphp

<x-splade-toggle :data="$isActive">
    <div class="flex flex-col gap-2">
        <div class="flex gap-2 my-auto">

            <x-nav-link :active="$isActive" :modal="$openAs == 'modal'" :slideover="$openAs == 'slideover'" :method="$method" :href="$route"
                :type="$type" {{ $attributes }}>
                @if (strlen($iconPath) > 0)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="my-auto w-5 h-5 {{ $isActive ? 'text-teal-500' : '' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
                    </svg>
                @endif
                {{ $label }}
            </x-nav-link>
            @if (strlen($slot) > 0)
                <div>
                    <svg @click.prevent="toggle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor"
                        class="w-6 h-6 my-auto cursor-pointer transition-all duration-300 {{ $isActive ? 'text-teal-600' : '' }}"
                        v-bind:class="{ 'rotate-90' :toggled}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            @endif
        </div>
        @if (strlen($slot) > 0)
            <x-splade-transition enter='duration-300' show="toggled">
                <div class="flex flex-col gap-4 border-l border-teal-500 pl-4 ml-3 pt-4 border-dashed">
                    {{ $slot }}
                </div>
            </x-splade-transition>
        @endif
    </div>
</x-splade-toggle>
