    <div class="flex flex-col w-full h-screen relative bg-slate-950">
        @guest
            <x-splade-modal name="login-required" class="absolute w-1/2 mx-auto bg-slate-900 shadow-md shadow-fuchsia-400"
                position="center">
                <div class="p-8 mx-auto flex flex-col items-center justify-center gap-4">
                    <h1 class="text-xl font-medium text-white">Login required</h1>
                    <x-layouts.navigation-link class="text-white bg-fuchsia-600 hover:bg-fuchsia-700" type="call-to-action"
                        resource="login" label="Login and continue" />
                </div>
            </x-splade-modal>
        @endguest
        <div class="flex items-center gap-6 justify-between w-full  text-white shadow shadow-fuchsia-200/30">
            <div class="flex gap-2 items-center px-6 md:px-20 lg:px-32 py-2 pr-0 ">
                <span
                    class="justify-center p-1 bg-green-400 rounded-full text-slate-800 flex items.center capitalize flex-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="{{ strlen($icon) > 0 ? $icon : 'M12 6v12m6-6H6' }}" />
                    </svg>
                </span>
                <h1 class="text-xl font-medium text-green-400 whitespace-nowrap w-32 overflow-hidden text-ellipsis">
                    {{ empty($activePage) ? 'Welcome' : $activePage }}
                </h1>
            </div>
            <div class="flex gap-6 items-center text-fuchsia-200 w-fit transition-all duration-200 p-4 px-6 md:px-20 lg:px-32 pl-0 overflow-x-auto"
                @preserveScroll('navigationFilter')>
                @if (!Route::is('welcome'))
                    <x-layouts.navigation-link class="" resource="welcome" label="Landing page"
                        icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                @endif
                @if (!Route::is('topics.index'))
                    <x-layouts.navigation-link resource="topics" action="index" label="Topics"
                        icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                @endif
                @if (!Route::is('skills.index'))
                    <x-layouts.navigation-link resource="skills" action="index" label="Skills"
                        icon="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                @endif

                @if (!Route::is('fields.index'))
                    <x-layouts.navigation-link resource="fields" action="index" label="Fields"
                        icon="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                @endif
                <x-authentication />
            </div>
        </div>
        <div class="grow overflow-hidden relative">
            {{ $slot }}
        </div>
    </div>
