<x-layouts.app
    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
    <div class="relative h-full overflow-hidden overflow-y-auto text-slate-600 dark:text-slate-100 p-6 lg:px-80"
        @preserveScroll('notesIndex')>
        <x-notes-filter :$filter />
        <note v-slot="note">
            <ul class="flex flex-col gap-16 mt-8">
                <li class="flex flex-wrap gap-2 justify-between border-b border-slate-400/30 pb-1">
                    <h1 class="font-bold ml-auto w-fit">
                        <Link href="{{ route('notes.store') }}" method="post" class="group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6  text-fuchsia-400 group-hover:text-fuchsia-600 transition-all duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        </Link>
                    </h1>
                </li>
                @forelse ($notes as $note)
                    <li class="flex flex-col flex-wrap gap-2 justify-between border-b border-slate-400/30 pb-2">
                        <h1
                            class="text-lg font-medium first-letter:uppercase text-fuchsia-500 group-hover:text-fuchsia-600 transition-all duration-300">
                            <Link href="{{ route('notes.edit', $note) }}">
                            {{ $note->extractTitle() }}
                            </Link>
                        </h1>
                        <div class="flex flex-wrap items-center gap-6">
                            <span class="text-slate-400">{{ $note->author->name }}</span>
                            <span class="text-slate-400" v-text="note.extractDate('{{ $note->updated_at }}')"></span>
                            <x-note.categories :$note />
                            <Link method="delete" href="{{ route('notes.destroy', $note) }}"
                                confirm-danger="Delete requested" confirm-text="This note will be permanently deleted"
                                confirm-button="Yes, delete this note permanently" cancel-button="No don't delete"
                                class="ml-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            </Link>
                        </div>
                    </li>
                @empty
                    <p class="text-xl mb-4 dark:text-white">No notes matches the filter</p>
                @endforelse
            </ul>
        </note>
    </div>
</x-layouts.app>
