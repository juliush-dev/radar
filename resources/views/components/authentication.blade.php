<div>
    @if (Route::has('login'))
        <div {{ $attributes->class(['flex', 'items-center', 'gap-6']) }}>
            @auth
                <div class="flex gap-4 items-center justify-center">
                    <x-nav-link href="{{ route('logout') }}" method="post"
                        class="whitespace-nowrap hover:text-fuchsia-900 dark:hover:text-fuchsia-500">
                        Logout
                    </x-nav-link>
                </div>
            @else
                <div class="flex gap-2 items-center justify-center">
                    @if (!Route::is('login') || Route::is('register'))
                        <x-nav-link href="{{ route('login') }}"
                            class="whitespace-nowrap hover:text-fuchsia-900 dark:hover:text-fuchsia-500">
                            Login
                        </x-nav-link>
                    @endif
                    @if (!Route::is('register') && Route::has('register'))
                        <span class="mx-4 my-auto dark:text-slate-100 text-slate-500 text-md">or</span>
                        <x-nav-link href="{{ route('register') }}"
                            class="whitespace-nowrap hover:text-fuchsia-900 dark:hover:text-fuchsia-500 mr-2">
                            Create an account
                        </x-nav-link>
                    @endif
                </div>
            @endauth
            @auth
                @if (!Route::is('profile.edit'))
                    <x-nav-link :href="route('profile.edit', Auth::user())" class="whitespace-nowrap mr-2">
                        My Profile
                    </x-nav-link>
                @endif
            @endauth
        </div>
    @endif
</div>
