<x-layouts.app
    icon="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9">
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" />
        <div class="font-medium text-xl capitalize">Login form</div>
        <x-splade-form action="{{ route('login') }}" class="space-y-4">
            <!-- Email Address -->
            <x-splade-input id="email" type="email" name="email" :label="__('Email')" required autofocus />
            <x-splade-input id="password" type="password" name="password" :label="__('Password')" required
                autocomplete="current-password" />
            <x-splade-checkbox id="remember_me" name="remember" :label="__('Remember me')" />
            <div class="flex items-center justify-end gap-5 flex-wrap text-end">
                <x-splade-submit class="whitespace-nowrap bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md"
                    :label="__('Log in')" />
                @if (Route::has('password.request'))
                    <x-nav-link href="{{ route('password.request') }}" class="text-xs">
                        Reset password
                    </x-nav-link>
                @endif
                <x-nav-link href="{{ route('register') }}" class="text-xs">
                    Create an account
                </x-nav-link>
            </div>
        </x-splade-form>
    </x-auth-card>
</x-layouts.app>
