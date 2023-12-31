@php
    $relatives = $category->notes
        ->map(function ($relative) {
            return ['id' => $relative->id, 'title' => $relative->extractTitle()];
        })
        ->all();
@endphp
<section v-if="@js(count($relatives) > 0)" {{ $attributes }}>
    <ul class="flex flex-col gap-4 mt-3 soft text-blue-400 dark:text-blue-400/30">
        @foreach ($relatives as $relative)
            <li>
                <button @click="form.$put('note', @js($relative['id']))">
                    {{ $relative['title'] }}
                </button>
            </li>
        @endforeach
    </ul>
</section>
