<x-layouts.app active-page="Topics gallery"
    icon="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
    @if ($topics->count() == 0 && !$filterIsSet)
        <div class="flex flex-col justify-center items-center w-full h-full">
            <p class="font-mono text-xl mb-4">The gallery looks empty</p>
            @if (!auth()->check())
                <x-layouts.navigation-link class="mx-auto bg-cyan-600 text-white hover:bg-cyan-700" type="call-to-action"
                    resource="login" label="Login and start adding some topics to it"
                    icon="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            @else
                <x-layouts.navigation-link class="mx-auto bg-cyan-600 text-white hover:bg-cyan-700" type="call-to-action"
                    resource="topics" action="create" label="Add new topic"
                    icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            @endif
        </div>
    @else
        <x-slot:content-header>
            <div class="w-full flex gap-4 px-5 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 -mt-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <x-topics-filter :years="$rq->years()" :subjects="$rq->subjects()" :fields="$rq->fields()" :skills="$rq->skills()" />
            </div>
        </x-slot>
        <div class="h-full overflow-y-auto">
            <div id="gallery" class="topics columns-1 sm:columns-2 lg:columns-4 p-6 gap-6 space-y-6 mx-auto"
                @preserveScroll('topicsGallery')>

                @foreach ($topics as $topic)
                    <x-topic :topic="$topic" />
                @endforeach
                <Link href="{{ Auth::check() ? route('topics.create') : '#login-required' }}"
                    class="drop-shadow-lg h-[290px] bg-slate-100 hover:bg-slate-200 w-full break-inside-avoid border border-t-none flex items-center justify-center border-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                </Link>
            </div>
        </div>
    @endif
</x-layouts.app>
