<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-green-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-teal-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-splade-form method="delete" :action="route('profile.destroy', $user)" :confirm="__('Are you sure you want to delete your account?')" :confirm-text="__(
        'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
    )" :confirm-button="__('Delete Account')"
        require-password>
        <x-splade-submit class="bg-pink-400 hover:bg-pink-500 shadow hover:shadow-md transition duration-300"
            :label="__('Delete Account')" />
    </x-splade-form>
</section>
