<x-layouts.app>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" />
        <div class="font-medium text-xl mb-8 capitalize text-teal-600">Login form</div>
        <x-splade-form action="{{ route('login') }}" class="space-y-4">
            <!-- Email Address -->
            <x-splade-input id="email" type="email" name="email" :label="__('Email')" required autofocus />
            <x-splade-input id="password" type="password" name="password" :label="__('Password')" required
                autocomplete="current-password" />
            <x-splade-checkbox id="remember_me" name="remember" :label="__('Remember me')" />

            <div class="flex items-center justify-end gap-5">
                @if (Route::has('password.request'))
                    <x-nav-link href="{{ route('password.request') }}" small>
                        {{ __('Forgot your password ?') }}
                    </x-nav-link>
                @endif
                <x-nav-link href="{{ route('register') }}" small>
                    {{ __('New here ?') }}
                </x-nav-link>
                <x-splade-submit class="ml-3" :label="__('Log in')" />
            </div>
        </x-splade-form>
    </x-auth-card>
</x-layouts.app>
