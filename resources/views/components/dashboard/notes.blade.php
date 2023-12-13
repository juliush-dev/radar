<x-splade-table :for="$notes">
    @cell('title', $note)
        <Link href="{{ route('notes.edit', $note) }}"
            class="text-fuchsia-500 hover:text-fuchsia-600 transition-all duration-300 w-full whitespace-break-spaces">
        {{ $note->extractTitle() }}</Link>
    @endcell
    @cell('public', $note)
        @if ($note->is_public)
            <x-splade-form submit-on-change :action="route('notes.unpublish', $note)" method="patch">
                <button type="submit"
                    class="flex flex-nowrap whitespace-nowrap gap-2 items-center bg-orange-100 text-orange-900 dark:bg-orange-900 dark:text-orange-100 font-medium py-1 px-2 shadow rounded transition-all duration-300 hover:shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                    Unpublish
                </button>
            </x-splade-form>
        @else
            <x-splade-form submit-on-change :action="route('notes.publish', $note)" method="patch">
                <button type="submit"
                    class="flex flex-nowrap whitespace-nowrap gap-2 items-center bg-pink-100 text-pink-900 dark:bg-pink-900 dark:text-pink-100 font-medium py-1 px-2 shadow rounded transition-all duration-300 hover:shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Publish
                </button>
            </x-splade-form>
        @endif
    @endcell
    @cell('action', $note)
        <Link method="delete" href="{{ route('notes.destroy', $note) }}" confirm-danger="Delete requested"
            confirm-text="This note will be permanently deleted" confirm-button="Yes, delete this note permanently"
            cancel-button="No don't delete" class="ml-auto text-red-500 hover:text-red-600 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        </Link>
    @endcell
</x-splade-table>
