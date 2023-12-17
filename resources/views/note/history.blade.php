<x-layouts.app>
    <x-splade-modal close-explicitly :close-button="false" class="bg-white dark:bg-slate-800 dark:text-slate-400">
        <ul class="flex flex-col gap-6 p-6">
            @foreach ($lastOpened as $note)
                <Link href="{{ route('notes.edit', $note) }}"
                    class="text-base font-medium first-letter:uppercase text-fuchsia-500 group-hover:text-fuchsia-600 transition-all duration-300">
                {{ $note->extractTitle() }}
                </Link>
            @endforeach
        </ul>
        <button
            class="rounded fixed top-4 right-6 bg-sky-400 hover:bg-sky-500 transition-all duration-75 px-2 py-1 text-white"
            type="button" @click="modal.close">Done</button>
    </x-splade-modal>
</x-layouts.app>
