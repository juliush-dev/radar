<x-layouts.app>
    <div class="hero relative flex flex-col h-full items-center justify-center">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        </div>
        <div class="flex flex-col gap-8 items-center">
            <div class="flex flex-col gap-4">
                <div class="uppercase text-center text-5xl font-light">radar</div>
                <x-authentication />
            </div>
            <x-nav-link :href="route('skills.index')" type="call-to-action">
                Open the skills board
            </x-nav-link>
        </div>
    </div>
</x-layouts.app>
