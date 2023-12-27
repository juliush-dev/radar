@php
    $categories = $note->categories
        ->map(function ($category) {
            return ['id' => $category->id, 'name' => $category->name];
        })
        ->all();
@endphp
<section v-if="@js(count($categories) > 0)">
    @if ($inEditor)
        <h3 class="text-lg font-medium">Categorized as</h3>
    @endif
    <ul class="flex @if ($inEditor) lg:flex-col mt-3 @endif gap-4 flex-wrap">
        @foreach ($categories as $category)
            <li class="w-fit">
                <Link href="{{ route('notes.filter') . "?categories%5B0%5D={$category['id']}" }}"
                    class="opacity-60 hover:opacity-100 font-normal flex gap-2 text-slate-500">
                #{{ $category['name'] }}
                </Link>
            </li>
        @endforeach
    </ul>
</section>
