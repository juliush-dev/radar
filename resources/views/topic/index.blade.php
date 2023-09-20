<x-layouts.app active-page="Topics gallery"
    icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">

    @if ($topics->count() == 0)
        <div class="flex flex-col justify-center items-center w-full h-full">
            <p class="font-mono text-xl mb-4">The gallery looks empty</p>
            @if (!auth()->check())
                <x-layouts.navigation-link class="mx-auto" type="call-to-action" resource="login"
                    label="Login and start adding some topics to it"
                    icon="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            @else
                <x-layouts.navigation-link class="mx-auto" type="call-to-action" resource="topics" action="create"
                    label="Add new topic"
                    icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            @endif
        </div>
    @else
        <div class="flex gap-4 px-20 pb-0  w-full h-full overflow-auto">
            {{-- @foreach ($topics as $skill)
            <x-topic :skill="$skill" class="grow-1" />
        @endforeach --}}
        </div>
    @endif

</x-layouts.app>
