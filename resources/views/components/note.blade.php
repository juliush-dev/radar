    <x-splade-form action="{{ route('notes.update', $note) }}" method="patch" :default="[
        'title' => $note->title,
        'editable' => $note->editable,
        'updated_at' => $note->updated_at,
        'content' => $note->content,
    ]" stay background
        submit-on-change="content, editable" debounce="500" class="note">
        @can('edit-note', [$note])
            <tip-tap v-model="form.content" :title="form.$response?.title || form.title" :editable="form.editable == 1"
                author="{{ $note->author->name }}" created-at="{{ $note->created_at }}"
                :updated-at="form.$response?.updated_at ?? form.updated_at" new-note-endpoint="{{ route('notes.store') }}"
                delete-note-endpoint="{{ route('notes.destroy', $note) }}" :form="form" />
        @endcan
    </x-splade-form>
