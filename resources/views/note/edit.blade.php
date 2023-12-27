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
                class="mt-8 lg:flex flex-col hidden h-[91%] lg:fixed lg:right-0 lg:w-80  py-[1px] lg:top-7 lg:bottom-0 lg:pt-6 lg:overflow-y-auto lg:pb-4 text-blue-400 dark:text-blue-400/30">
                <div class="px-6 fixed top-20 mt-2 w-48 z-10">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <x-splade-button type="call-to-action" label="Actions" class="backdrop-blur">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </x-splade-button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="flex flex-col p-6 gap-4 h-full w-full soft">
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
                        </x-slot>
                    </x-dropdown>
                </div>
                <x-splade-form method="get" action="{{ route('notes.modal') }}" stay background submit-on-change
                    class="w-full flex-1 px-6 pb-6 mt-16 rounded-md text-zinc-400 dark:text-zinc-400/30">
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
