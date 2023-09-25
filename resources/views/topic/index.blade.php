<x-layouts.app active-page="Topics gallery"
    icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
    @if ($topics->count() == 0 && !$filterIsSet)
        <div class="flex flex-col justify-center items-center w-full h-full">
            <p class="font-mono text-xl mb-4">The gallery looks empty</p>
            @if (!auth()->check())
                <x-layouts.navigation-link class="mx-auto bg-slate-800 text-white hover:bg-slate-700"
                    type="call-to-action" resource="login" label="Login and start adding some topics to it"
                    icon="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            @else
                <x-layouts.navigation-link class="mx-auto bg-slate-800 text-white hover:bg-slate-700"
                    type="call-to-action" resource="topics" action="create" label="Add new topic"
                    icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            @endif
        </div>
    @else
        <x-slot:content-header>
            <div class="bg-slate-800 w-full text-white flex gap-4 px-6 items-center pb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <x-topics-filter :years="$rq->years()" :subjects="$rq->subjects()" :fields="$rq->fields()" :skills="$rq->skills()" />
            </div>
        </x-slot>
        <div class="grow topics columns-1 sm:columns-2 lg:columns-4 p-6 gap-6 space-y-6 mx-auto" @preserveScroll('topicsGallery')>
            @auth

                <Link href="{{ route('topics.create') }}"
                    class="h-[300px] hover:bg-slate-200 w-full break-inside-avoid border border-t-none flex items-center justify-center border-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                </Link>
            @endauth
            @foreach ($topics as $topic)
                <x-topic :topic="$topic" />
            @endforeach

        </div>
    @endif
</x-layouts.app>
