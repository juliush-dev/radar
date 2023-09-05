<x-layouts.app>
    <div class="flex flex-col h-full items-center justify-center">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        </div>
        <div class="flex flex-col gap-8 items-center">
            <div class="flex flex-col gap-4">
                <div class="uppercase text-center text-5xl font-light">radar</div>
                <x-authentication />
            </div>
            <x-nav-link :href="route('skill.index')" type="call-to-action">
                Acquire these skills before it is too late
            </x-nav-link>
        </div>
    </div>
</x-layouts.app>
