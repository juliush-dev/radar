@php
    $categories = $note->categories
        ->map(function ($category) {
            return ['id' => $category->id, 'name' => $category->name];
        })
        ->all();
@endphp
@if ($inEditor)
    <section v-if="@js(count($categories) > 0)" {{ $attributes->merge(['class' => 'overflow-y-auto p-6']) }}>
        <h3 class="text-lg font-medium  flex flex-nowrap gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
            </svg>
            Note categories
        </h3>
        <ul class="flex flex-col mt-3 gap-4">
            @foreach ($categories as $category)
                <li class="w-fit">
                    <Link href="{{ route('notes.filter') . "?categories%5B0%5D={$category['id']}" }}"
                        class="font-normal flex gap-2">
                    #{{ $category['name'] }}
                    </Link>
                </li>
            @endforeach
        </ul>
    </section>
@else
    <ul class="flex gap-4 flex-wrap">
        @foreach ($categories as $category)
            <li class="w-fit">
                <Link href="{{ route('notes.filter') . "?categories%5B0%5D={$category['id']}" }}"
                    class="font-normal flex gap-2">
                #{{ $category['name'] }}
                </Link>
            </li>
        @endforeach
    </ul>
@endif
