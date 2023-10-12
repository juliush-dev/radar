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
            'transition-all duration-200 bg-cyan-500  shadow-lg hover:bg-cyan-600 hover:shadow-md p-4 rounded-none py-0 w-fit' =>
                $type == 'call-to-action',
        ]) }}>
        <div class="flex gap-2 my-auto whitespace-nowrap items-center justify-center py-2">
            <x-nav-link :active="$isActive" :modal="$openAs == 'modal'" :slideover="$openAs == 'slideover'" :method="$method" :href="$route"
                :type="$type">
                @if (strlen($icon) > 0)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="my-auto w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                    </svg>
                @endif
                {{ $label }}
            </x-nav-link>
        </div>
    </div>
</x-splade-toggle>
