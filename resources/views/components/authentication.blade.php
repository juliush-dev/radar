<div>
    @if (Route::has('login'))
        <div class="flex items-center gap-6">
            @auth
                <div class="flex gap-4 items-center justify-center">
                    <x-nav-link href="{{ route('logout') }}" method="post" class="flex items-center gap-2 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 my-auto">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </x-nav-link>
                </div>
            @else
                <div class="flex gap-4 items-center justify-center">
                    @if (!Route::is('login') || Route::is('register'))
                        <x-nav-link href="{{ route('login') }}" class="flex items-center gap-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 my-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Login
                        </x-nav-link>
                    @endif
                    @if (!Route::is('register') && Route::has('register'))
                        <span class="mx-4 my-auto text-white">or</span>
                        <x-nav-link href="{{ route('register') }}" class="mr-2 flex items-center gap-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 my-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Create an account
                        </x-nav-link>
                    @endif
                </div>
            @endauth
            @auth
                <div class="flex gap-2 items-center">
                    <div class="w-8 h-8 -mb-0.5 rounded-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1771&q=80"
                            alt="Avatar" height="15px" width="auto" class="object-cover w-full h-full">
                    </div>
                </div>
            @endauth
        </div>
    @endif
</div>
