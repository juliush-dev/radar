<x-layouts.app
    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
    <div class="p-6">
        <note v-slot="note">
            <x-note :$note :$pile />
        </note>
        <div
            class=" border-t border-fuchsia-400/50 lg:border-none mt-3 pt-4 flex  flex-wrap gap-10 lg:flex-col lg:fixed lg:left-0 lg:w-80 lg:px-6 py-[1px] lg:top-7 lg:bottom-0 lg:pt-11 lg:overflow-y-auto lg:pb-4">
            <x-note.categories inEditor="true" :$note />
        </div>
        @if (!Agent::isPhone())
            <div
                class="lg:flex flex-col hidden h-[97%] lg:fixed lg:right-0 lg:w-80  py-[1px] lg:top-7 lg:bottom-0 lg:pt-6 lg:overflow-y-auto lg:pb-4 text-blue-400 dark:text-blue-400/30">
                <div
                    class="flex flex-col px-6 pb-6 pt-8 gap-4 w-full soft sticky top-0 bg-slate-100/90 dark:bg-slate-950/90 z-10">
                    <Link @click.prevent slideover href="{{ route('notes.history') }}">
                    History
                    </Link>
                    <Link @click.prevent slideover href="{{ route('notes.relatives', $note) }}">
                    Toggle references
                    </Link>
                    <Link @click.prevent slideover href="{{ route('categories.index', $note) }}">
                    Toggle Categories
                    </Link>
                    <Link @click.prevent slideover href="{{ route('categories.edit', $note) }}">
                    Edit Categories
                    </Link>
                    <Link @click.prevent slideover href="{{ route('categories.create', $note) }}">
                    New Category
                    </Link>
                    <Link @click.prevent slideover href="{{ route('categories.delete', $note) }}">
                    Delete Categories
                    </Link>
                </div>
                <x-splade-form method="get" action="{{ route('notes.modal') }}" stay background submit-on-change
                    class="w-full flex-1 px-6 pb-6 rounded-md text-zinc-400 dark:text-zinc-400/30">
                    <x-note.referers :$note />
                    <div class="h-8"></div>
                    <x-note.relatives :$note />
                    <template v-if="form.wasSuccessful">
                        <modal-note :form-response="form.$response" />
                    </template>
                </x-splade-form>
            </div>
        @endif
    </div>
</x-layouts.app>
