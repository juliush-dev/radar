<x-layouts.app active-page="Profile update"
    icon="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
    <x-splade-modal>
        <div class="py-12">
            <div class="w-fit mx-auto space-y-6 px-6 lg:px-10">
                <div class="p-4 sm:p-8 shadow border border-slate-400/40 rounded-md">
                    <div class="max-w-xl" dusk="update-profile-information">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 shadow border border-slate-400/40 rounded-md">
                    <div class="max-w-xl" dusk="update-password">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 shadow border border-slate-400/40 rounded-md">
                    <div class="max-w-xl" dusk="delete-user">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </x-splade-modal>
</x-layouts.app>
