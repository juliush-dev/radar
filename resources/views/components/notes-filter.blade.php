@php
    $categoriesOptions = \App\Models\Category::options($filter['categories'] ?? []);
@endphp

<x-splade-form action="{{ route('notes.filter') }}" method="get" :default="[
    'categories' => $filter['categories'] ?? [],
]" submit-on-change
    class="flex flex-col p-6">
    <h3 class="text-lg font-semibold  mb-6">Notes by categories</h3>
    <ul class="flex flex-col gap-6" @preserveScroll('NotesFilter')>
        @foreach ($categoriesOptions as $categoryOption)
            <li>
                <label class="flex gap-2">
                    <input type="checkbox" v-model="form.categories" value="{{ $categoryOption['id'] }}">
                    <span class="soft -mt-1"><span
                            class="font-medium text-lg">{{ $categoryOption['name'] }}</span></span>
                </label>
            </li>
        @endforeach
    </ul>
</x-splade-form>
