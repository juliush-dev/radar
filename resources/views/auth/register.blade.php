<x-layouts.app
    icon="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
    <x-auth-card>
        <div class="font-medium text-xl capitalize">Registration form</div>
        <x-splade-form action="{{ route('register') }}" class="space-y-4">
            <x-splade-input id="name" type="text" name="name" :label="__('Name')" required autofocus />
            <x-splade-input id="email" type="email" name="email" :label="__('Email')" required />
            <x-splade-input id="password" type="password" name="password" :label="__('Password')" required
                autocomplete="new-password" />
            <x-splade-input id="password_confirmation" type="password" name="password_confirmation" :label="__('Confirm Password')"
                required />
            <div class="flex items-center justify-end gap-5 flex-wrap text-end">
                <x-splade-submit class="whitespace-nowrap bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md"
                    :label="__('Register')" />
                <x-authentication />
            </div>
        </x-splade-form>
    </x-auth-card>
</x-layouts.app>
