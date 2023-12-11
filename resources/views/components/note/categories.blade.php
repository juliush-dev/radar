@php
    $categories = $note->categories
        ->map(function ($category) {
            return ['id' => $category->id, 'name' => $category->name];
        })
        ->all();
@endphp
<section v-if="@js(count($categories) > 0)">
    <ul class="flex gap-4 flex-wrap">
        @foreach ($categories as $category)
            <li class="w-fit">
                <Link href="{{ route('notes.filter') . "?categories%5B0%5D={$category['id']}" }}"
                    class="opacity-60 hover:opacity-100 font-semibold flex gap-2 text-slate-500">
                #{{ $category['name'] }}
                </Link>
            </li>
        @endforeach
    </ul>
</section>
