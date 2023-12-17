<div class="mx-auto w-full overflow-hidden note mb-6 transition-all duration-300">
    <x-splade-form action="{{ route('notes.update', $note) }}" method="patch" :default="[
        'content' => $note->content,
        'updated_at' => $note->updated_at,
    ]"
        class="flex flex-col justify-between overflow-hidden w-full" stay background submit-on-change="content">
        <div class="flex flex-wrap md:items-center gap-6 mb-3 w-full" id="{{ $note->id }}">
            <div class="font-medium text-slate-400 first-letter:uppercase dark:text-slate-600">
                {{ $note->author->name }}
            </div>
            @auth
                @can('edit-note', [$note])
                    <div class="flex flex-wrap gap-6 md:ml-auto">
                        <span v-text="note.extractDate('{{ $note->created_at }}')" class="text-slate-400"></span>
                        <span
                            v-text="note.extractDate(form.updated_at = (form.$response && form.$response.updated_at) ? form.$response.updated_at : form.updated_at)"
                            class="text-slate-400"></span>
                        <Link id="new-note" method="post" href="{{ route('notes.store') }}" class="dark:text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        </Link>
                        <Link id="delete-note" method="delete" href="{{ route('notes.destroy', $note) }}"
                            confirm-danger="Delete requested" confirm-text="This note will be permanently deleted"
                            confirm-button="Yes, delete this note permanently" cancel-button="No don't delete"
                            class="dark:text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        </Link>
                    </div>
                @endcan
            @endauth
        </div>
        @can('edit-note', [$note])
            <tip-tap v-model="form.content" note-id="@js($note->id)" :form="form" />
        @else
            <div class="ProseMirror" v-html="form.content"></div>
        @endcan
    </x-splade-form>
    <div class="flex flex-col gap-6">
        <x-note.referers :$note />
        <x-note.relatives :$note />
        <x-note.categories :$note />
    </div>
    <div class="flex gap-6 flex-wrap mt-8 lg:flex-col lg:fixed lg:right-0 lg:w-80 lg:px-6 py-[1px] lg:top-12">
        <Link @click.prevent slideover href="{{ route('notes.history') }}" class="text-blue-400">
        History
        </Link>
        <Link @click.prevent slideover href="{{ route('notes.relatives', $note) }}" class="text-blue-400">
        Relatives
        </Link>
        <Link @click.prevent slideover href="{{ route('categories.index', $note) }}" class="text-blue-400">
        Categories
        </Link>
        <Link @click.prevent slideover href="{{ route('categories.edit', $note) }}" class="text-blue-400">
        Edit Categories
        </Link>
        <Link @click.prevent slideover href="{{ route('categories.create', $note) }}" class="text-blue-400">
        New Category
        </Link>
        <Link @click.prevent slideover href="{{ route('categories.delete', $note) }}" class="text-blue-400">
        Delete Categories
        </Link>
    </div>
</div>
