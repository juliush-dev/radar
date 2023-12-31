@php
    $relatives = [];
    $notes = [];
    if (empty($category)) {
        $notes = $note->relatives;
    } else {
        $notes = $category->notes->filter(fn($n) => $n->id != $note?->id);
    }
    $relatives = $notes
        ->map(function ($relative) {
            return ['id' => $relative->id, 'title' => $relative->extractTitle()];
        })
        ->sortBy('title', SORT_NATURAL)
        ->all();
@endphp
<section v-if="@js(count($relatives) > 0)" {{ $attributes }}>
    @if (empty($category))
        <h3 class="text-lg font-medium flex flex-nowrap gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
            </svg>
            <span>Refer</span>
        </h3>
    @endif
    <ul class="flex flex-col gap-4 mt-3 soft text-blue-400 dark:text-blue-400/30 ml-0.5">
        @foreach ($relatives as $relative)
            <li>
                <button @click="form.$put('note', @js($relative['id']))">
                    {{ $relative['title'] }}
                </button>
            </li>
        @endforeach
    </ul>
</section>
