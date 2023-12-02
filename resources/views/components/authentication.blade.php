<div>
    @if (Route::has('login'))
        <div class="flex items-center gap-6">
            @auth
                <div class="flex gap-4 items-center justify-center">
                    <x-nav-link href="{{ route('logout') }}" method="post"
                        class="whitespace-nowrap hover:text-fuchsia-700 dark:hover:text-fuchsia-600 flex items-center gap-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 my-auto">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </x-nav-link>
                </div>
            @else
                <div class="flex gap-2 items-center justify-center">
                    @if (!Route::is('login') || Route::is('register'))
                        <x-nav-link href="{{ route('login') }}"
                            class="whitespace-nowrap hover:text-fuchsia-700 dark:hover:text-fuchsia-600 flex items-center gap-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4 my-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Login
                        </x-nav-link>
                    @endif
                    @if (!Route::is('register') && Route::has('register'))
                        <span class="mx-4 my-auto dark:text-slate-100 text-slate-500 text-md">or</span>
                        <x-nav-link href="{{ route('register') }}"
                            class="whitespace-nowrap hover:text-fuchsia-700 dark:hover:text-fuchsia-600 mr-2 flex items-center gap-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4 my-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Create an account
                        </x-nav-link>
                    @endif
                </div>
            @endauth
            @auth
                @if (!Route::is('profile.edit'))
                    <x-nav-link :href="route('profile.edit', Auth::user())" class="whitespace-nowrap mr-2 flex items-center gap-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        My Profile
                    </x-nav-link>
                @endif
            @endauth
        </div>
    @endif
</div>
