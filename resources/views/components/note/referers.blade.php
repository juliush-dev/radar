@php
    $referers = $note->relativeOf
        ->map(function ($referer) {
            return ['id' => $referer->id, 'title' => $referer->extractTitle()];
        })
        ->sortBy('title', SORT_NATURAL)
        ->all();
@endphp
<section v-if="@js(count($referers) > 0)" {{ $attributes }}>
    <h3 class="text-lg font-medium flex flex-nowrap gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
        </svg>
        <span>Referenced by</span>
    </h3>
    <ul class="flex flex-col gap-4 mt-3 soft text-blue-400 dark:text-blue-400/30 ml-0.5">
        @foreach ($referers as $referer)
            <li>
                <button @click="form.$put('note', @js($referer['id']))" class="break-words max-w-sm lg:w-60">
                    {{ $referer['title'] }}
                </button>
            </li>
        @endforeach
    </ul>
</section>
