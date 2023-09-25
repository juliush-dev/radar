@php
    $routeName = empty($action) ? $resource : $resource . '.' . $action;
    $isInlineLink = str_starts_with($routeName, '#');
    $postActions = ['update', 'store', 'reject', 'publish', 'approve', 'hide'];
    $method = 'get';
    if (in_array($action, $postActions) || $resource == 'logout') {
        $method = 'post';
    } elseif ($action == 'destroy') {
        $method = 'delete';
    } elseif ($isInlineLink) {
        $method = '';
    }
    $route = isset($actionArgs) ? ($isInlineLink ? $routeName : route($routeName, $actionArgs)) : ($isInlineLink ? $routeName : route($routeName));
    $isActive = $type == 'call-to-action' ? false : request()->routeIs($routeName);
    // || request()->url() == $route || str_starts_with(Route::currentRouteName(), $resource);
@endphp

<x-splade-toggle :data="$isActive">
    <div
        {{ $attributes->class([
            'flex flex-col gap-2',
            'transition-all duration-200 bg-cyan-500 ring ring-offset-1 ring-cyan-600/10 shadow-lg hover:bg-cyan-600 hover:shadow-md p-2 rounded py-3 w-fit' =>
                $type == 'call-to-action',
        ]) }}>
        <div class="flex gap-2 my-auto items-center justify-center">
            <x-nav-link :active="$isActive" :modal="$openAs == 'modal'" :slideover="$openAs == 'slideover'" :method="$method" :href="$route"
                :type="$type">
                @if (strlen($icon) > 0)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="my-auto w-5 h-5 mb-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
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
            @if ($dorpdown)
                <x-splade-transition enter='duration-300' show="toggled">
                    <div class="flex flex-col gap-4 border-l border-teal-500 pl-4 ml-3 pt-4 border-dashed">
            @endif
            {{ $slot }}
            @if ($dropdown)
    </div>
    </x-splade-transition>
    @endif
    @endif
    </div>
</x-splade-toggle>
