<div class="w-full note border p-3 lg:p-6 mb-[130%] lg:mb-[45%] rounded-b-md dark:border-slate-400/10">
    <x-splade-form action="{{ route('notes.update', $note) }}" method="patch" :default="[
        'content' => $note->content,
        'updated_at' => $note->updated_at,
    ]" stay background
        submit-on-change="content" debounce="500">
        <div class="flex flex-wrap md:items-center gap-6 mb-8 w-full" id="{{ $note->id }}">
            <div class="font-medium text-slate-400 first-letter:uppercase dark:text-slate-600">
                {{ $note->author->name }}
            </div>
            @auth
                @can('edit-note', [$note])
                    <div class="flex flex-wrap gap-6 md:ml-auto">
                        <span v-text="note.extractDate('{{ $note->created_at }}')"></span>
                        <span
                            v-text="note.extractDate(form.updated_at = (form.$response && form.$response.updated_at) ? form.$response.updated_at : form.updated_at)"
                            class="mr-6"></span>
                        <div class="flex gap-6 flex-nowrap items-center -mt-1">
                            <Link id="new-note" method="post" href="{{ route('notes.store') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 -mb-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            </Link>
                            <Link id="delete-note" method="delete" href="{{ route('notes.destroy', $note) }}"
                                confirm-danger="Delete requested" confirm-text="This note will be permanently deleted"
                                confirm-button="Yes, delete this note permanently" cancel-button="No don't delete">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 -mb-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            </Link>
                        </div>
                    </div>
                @endcan
            @endauth
        </div>
        @can('edit-note', [$note])
            <tip-tap v-model="form.content" note-id="@js($note->id)" :form="form" />
        @endcan
    </x-splade-form>
</div>
