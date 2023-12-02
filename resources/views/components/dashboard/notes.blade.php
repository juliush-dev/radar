<x-splade-table :for="$notes">
    @cell('title', $note)
        <Link href="{{ route('topics.show', $note->topic) . "#{$note->id}" }}"
            class="text-fuchsia-500 hover:text-fuchsia-600 transition-all duration-300">
        {{ $note->extractTitle() }}</Link>
    @endcell
    {{-- @cell('topic', $note)
        {{ $note->topic->title }}
    @endcell --}}
    @cell('public', $note)
        <x-splade-form submit-on-change :action="route('topics.notes.update', $note)" method="patch" :default="['is_public' => $note->is_public]">
            <x-splade-checkbox name="is_public" value="1" class="checked:bg-fuchsia-400" />
        </x-splade-form>
    @endcell
    @cell('action', $note)
        <x-splade-link method="delete" href="{{ route('topics.notes.delete', $note) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 text-red-500 hover:text-red-600 transition-all duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </x-splade-link>
    @endcell
</x-splade-table>
