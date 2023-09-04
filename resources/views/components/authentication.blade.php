<div>
    @if (Route::has('login'))
        <div class="text-center">
            @auth
                <x-nav-link href="{{ route('logout') }}" method="post" small>
                    Logout
                </x-nav-link>
            @else
                <x-nav-link href="{{ route('login') }}" small>
                    Login
                </x-nav-link>
                <span class="mx-4 text-sm">or</span>
                @if (Route::has('register'))
                    <x-nav-link href="{{ route('register') }}" small>
                        Become a contributor
                    </x-nav-link>
                @endif
            @endauth
        </div>
    @endif
</div>
