<x-splade-form action="{{ route('notes.filter') }}" method="get" preserve-scroll :default="[
    'categories' => $filter['categories'] ?? [],
]" submit-on-change
    debounce="300">
    <ul class="flex flex-col lg:flex-row flex-wrap gap-6 mb-6">
        @foreach (\App\Models\Category::options() as $category)
            <li>
                <label class="flex gap-2 items-center">
                    <input type="checkbox" class="rounded border-fuchsia-200" v-model="form.categories"
                        value="{{ $category['id'] }}">
                    <span class="soft mt-1"><span class="font-medium text-lg">{{ $category['name'] }}</span></span>
                </label>
            </li>
        @endforeach
    </ul>
</x-splade-form>
