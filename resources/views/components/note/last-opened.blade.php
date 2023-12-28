<div {{ $attributes->merge(['class' => 'overflow-y-auto px-6']) }}>
    <h3 class="text-lg font-medium mb-3 flex flex-nowrap gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        Last opened
    </h3>
    <ul class="flex flex-col gap-6">
        @foreach ($lastOpened as $note)
            <Link href="{{ route('notes.edit', $note) }}"
                class="soft first-letter:uppercase text-fuchsia-500 dark:text-fuchsia-500/40 group-hover:text-fuchsia-600 transition-all duration-300">
            {{ $note->extractTitle() }}
            </Link>
        @endforeach
    </ul>
</div>
