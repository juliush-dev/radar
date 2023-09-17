<x-layouts.app>
    <x-auth-card>
        <div class="font-medium text-xl mb-8 capitalize text-teal-600">Contributor registration form</div>
        <x-splade-form action="{{ route('register') }}" class="space-y-4">
            <x-splade-input id="name" type="text" name="name" :label="__('Name')" required autofocus />
            <x-splade-input id="email" type="email" name="email" :label="__('Email')" required />
            <x-splade-input id="password" type="password" name="password" :label="__('Password')" required
                autocomplete="new-password" />
            <x-splade-input id="password_confirmation" type="password" name="password_confirmation" :label="__('Confirm Password')"
                required />

            <div class="flex items-center justify-end gap-5">
                <x-authentication />
                <x-splade-submit class="ml-4" :label="__('Register')" />
            </div>
        </x-splade-form>
    </x-auth-card>
</x-layouts.app>
