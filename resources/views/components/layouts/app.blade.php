<div class="h-screen flex flex-col gap-8 items-center text-ellipsis">
    <section class="flex gap-6 justify-between p-6 xl:px-20 shadow w-full">
        <div class="flex gap-6 items-center">
            <h1 class="text-2xl text-teal-600 flex gap-2 items.center capitalize flex-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="{{ strlen($icon) > 0 ? $icon : 'M12 6v12m6-6H6' }}" />
                </svg>
                <span>{{ $activePage }}</span>
            </h1>

        </div>
        <div class="flex gap-6 items-center">
            <x-layouts.navigation-link resource="welcome" label="Landing page"
                icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            <x-layouts.navigation-link resource="topics" action="index" label="Topics gallery"
                icon="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            @auth
                <x-layouts.navigation-link resource="topics" action="create" label="New topic"
                    icon="M12 4.5v15m7.5-7.5h-15" />
            @endauth
            <x-authentication />
        </div>
    </section>
    @if (isset($contentHeader))
        {{ $contentHeader }}
    @endif
    <div @preserveScroll('mainView') class="w-full grow">
        {{ $slot }}
    </div>
    @if (!Auth::check())
        <x-splade-modal name="login-required" class="w-1/2 mx-auto" position="center">
            <div class="p-8 mx-auto flex flex-col items-center justify-center gap-4">
                <h1 class="text-xl font-medium">Login required</h1>
                <x-layouts.navigation-link type="call-to-action" resource="login" label="Login and continue" />
            </div>
        </x-splade-modal>
    @endif

</div>
