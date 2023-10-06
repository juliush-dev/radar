<section>
    <header>
        <h2 class="text-lg font-medium text-green-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-teal-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <x-splade-form method="put" :action="route('password.update', $user)" class="mt-6 space-y-6" preserve-scroll>
        <x-splade-input id="current_password" name="current_password" type="password" :label="__('Current Password')"
            autocomplete="current-password" />
        <x-splade-input id="password" name="password" type="password" :label="__('New Password')" autocomplete="new-password" />
        <x-splade-input id="password_confirmation" name="password_confirmation" type="password" :label="__('Confirm Password')"
            autocomplete="new-password" />

        <div class="flex items-center gap-4">
            <x-splade-submit
                class="bg-fuchsia-500 rounded-none hover:bg-fuchsia-600 shadow hover:shadow-md transition duration-300"
                :label="__('Save')" />

            @if (session('status') === 'password-updated')
                <p class="text-sm text-teal-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </x-splade-form>
</section>
