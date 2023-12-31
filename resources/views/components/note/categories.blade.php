@php
    $categories = $note
        ->categories()
        ->orderBy('name', 'asc')
        ->get();
@endphp
@if ($inEditor)
    <section v-if="@js(count($categories) > 0)" {{ $attributes->merge(['class' => 'overflow-y-auto p-6']) }}>
        <h3 class="text-lg font-medium  flex flex-nowrap gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
            </svg>
            In the same categories
        </h3>
        <ul class="flex flex-col mt-3 gap-4">
            @foreach ($categories as $category)
                <li class="w-fit ml-0.5">
                    <Link href="{{ route('notes.filter') . "?categories%5B0%5D={$category->id}" }}"
                        class="font-normal flex gap-2">
                    # {{ $category->name }}
                    </Link>
                    <x-note.relatives :$note :$category class="border-l pl-4 ml-1 dark:border-slate-400/5" />
                </li>
            @endforeach
        </ul>
    </section>
@else
    <ul class="flex gap-4 flex-wrap">
        @foreach ($categories as $category)
            <li class="w-fit">
                <Link href="{{ route('notes.filter') . "?categories%5B0%5D={$category->id}" }}"
                    class="font-normal flex gap-2">
                #{{ $category->name }}
                </Link>
            </li>
        @endforeach
    </ul>
@endif
