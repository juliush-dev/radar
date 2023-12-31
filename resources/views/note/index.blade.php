<x-layouts.app
    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
    @if (count($notes) > 0 || isset($filter['categories']))
        <x-slot:leftSide>
            <div class="h-full overflow-y-auto pb-20 shadow">
                <x-notes-filter :$filter />
            </div>
        </x-slot>
        <div class="px-6">
            <note v-slot="note">
                <ul class="flex flex-col gap-6 py-6">
                    <li class="lg:ml-auto flex flex-wrap font-bold items-center gap-6 mb-8">
                        @if (isset($filter) && count($filter) > 0)
                            <Link href="{{ route('notes.index') }}"
                                class="flex gap-2 items-center bg-slate-200 text-slate-900 dark:bg-slate-900 dark:text-slate-200 font-medium py-1 px-2 shadow rounded transition-all duration-300 hover:shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Reset Filter
                            </Link>
                        @endif
                        <Link href="{{ route('notes.store') }}" method="post"
                            class="flex gap-2 items-center bg-fuchsia-100 text-fuchsia-900 dark:bg-fuchsia-900/40 dark:text-fuchsia-100/40 font-medium py-1 px-2 shadow rounded transition-all duration-300 hover:shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        New note
                        </Link>
                    </li>
                    @forelse ($notes as $note)
                        <li
                            class="flex flex-col flex-wrap gap-2 justify-between border-b border-slate-400/30 pb-2 mb-6">
                            <h1
                                class="text-lg font-medium first-letter:uppercase text-fuchsia-500 dark:text-fuchsia-500/40 hover:text-fuchsia-600 dark:hover:text-fuchsia-500/60 transition-all duration-300">
                                <Link href="{{ route('notes.edit', $note) }}">
                                {{ $note->extractTitle() }}
                                </Link>
                            </h1>
                            <div class="flex flex-wrap items-center gap-6">
                                <span>{{ $note->author->name }}</span>
                                <span v-text="note.extractDate('{{ $note->updated_at }}')"></span>
                                <x-note.categories :$note />
                                @can('edit-note', [$note])
                                    <Link method="delete" href="{{ route('notes.destroy', $note) }}"
                                        confirm-danger="Delete requested"
                                        confirm-text="This note will be permanently deleted"
                                        confirm-button="Yes, delete this note permanently" cancel-button="No don't delete"
                                        class="ml-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    </Link>
                                @endcan
                            </div>
                        </li>
                    @empty
                        <p class="text-xl mb-4 dark:text-white">No notes matches the filter</p>
                    @endforelse
                </ul>
            </note>
        </div>
        <x-slot:rightSide>
            <x-note.last-opened :$lastOpened class="h-full pb-20 pt-6 shadow" />
        </x-slot>
    @else
        <div class="h-[96%] flex justify-center items-center">
            <div class="relative h-full lg:h-[500px] overflow-hidden flex w-full">
                <div class="relative w-full lg:w-1/2"
                    style="background-image:
                linear-gradient(30.8deg, rgba(0, 0, 0, 0.7) 30%,transparent 100%),
                radial-gradient(circle at 70% 40%, transparent, rgba(0, 0, 0, 1) 90%),
                url('{{ Vite::asset('resources/images/benjamin-child-rOn57CBgyMo-unsplash.jpg') }}');
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;">
                    <p class="absolute bottom-4 text-sm font-light text-slate-300/50 text-center w-full z-20">
                        Photo by <a
                            href="https://unsplash.com/@bchild311?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash"
                            class="underline">Benjamin
                            Child</a> on <a class="underline"
                            href="https://unsplash.com/photos/woman-in-black-tank-top-and-black-pants-sitting-on-green-grass-field-during-daytime-rOn57CBgyMo?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>
                    </p>
                </div>
                <div
                    class="absolute left-0 top-0 right-0 bottom-0 w-full lg:relative lg:w-1/2 flex items-center justify-center text-center lg:bg-fuchsia-100">
                    <p
                        class="soft text-2xl md:text-3xl lg:text-4xl h-[74%] p-8 lg:p-0  flex flex-col lg:gap-2 items-center justify-center leading-normal font-semibold uppercase w-2/3 text-slate-100 lg:text-fuchsia-900">
                        <span class="soft mb-2 block w-fit mt-auto lg:m-0">Don't hate.</span>
                        <span class="soft block w-fit">Take Notes</span>
                        <span class="soft block w-fit mb-2 md:mb-6 lg:m-0">and</span>
                        <span class="soft block w-fit">Meditate</span>
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-layouts.app>
