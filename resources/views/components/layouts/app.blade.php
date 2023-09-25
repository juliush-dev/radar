    <div class="flex flex-col w-full h-screen relative">
        @guest
            <x-splade-modal name="login-required" class="absolute w-1/2 mx-auto bg-slate-800/80" position="center">
                <div class="p-8 mx-auto flex flex-col items-center justify-center gap-4">
                    <h1 class="text-xl font-medium text-white">Login required</h1>
                    <x-layouts.navigation-link class="text-white bg-cyan-600 hover:bg-cyan-700" type="call-to-action"
                        resource="login" label="Login and continue" />
                </div>
            </x-splade-modal>
        @endguest
        <div class="flex items-center gap-6 justify-between w-full bg-slate-800 text-white">
            <div class="flex gap-2 items-center p-4 py-2">
                <span
                    class="justify-center p-1 bg-white rounded-full text-slate-800 flex items.center capitalize flex-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="{{ strlen($icon) > 0 ? $icon : 'M12 6v12m6-6H6' }}" />
                    </svg>
                </span>
                <h1 class="text-md ">
                    {{ empty($activePage) ? 'Welcome' : $activePage }}
                </h1>
            </div>
            <div class=" flex gap-6 items-center w-fit transition-all duration-200 p-4">
                <x-layouts.navigation-link class="" resource="welcome" label="Landing page"
                    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                @if (!Route::is('welcome'))
                    <x-layouts.navigation-link class="text-white" resource="topics" action="index"
                        label="Topics gallery"
                        icon="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                @endif
                <x-authentication />
            </div>
        </div>
        @if (isset($contentHeader))
            <div class="bg-slate-700 text-white w-full py-4 min-h-fit">
                {{ $contentHeader }}
            </div>
        @endif
        <div class="grow overflow-hidden relative">
            {{ $slot }}
        </div>
    </div>
