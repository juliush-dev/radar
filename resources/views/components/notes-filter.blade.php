<x-splade-modal slideover close-explicitly :close-button="false" name="notes-filter">
    <x-splade-form action="{{ route('notes.filter') }}" method="get" preserve-scroll :default="[
        'categories' => $filter['categories'] ?? [],
    ]" class="bg-white">
        <ul class="flex flex-col gap-6 mb-6 p-8">
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
        <button type="submit"
            class="rounded fixed top-4 right-6 bg-sky-400 hover:bg-sky-500 transition-all duration-75 px-2 py-1 text-white"
            @click="modal.close">Done</button>
    </x-splade-form>
</x-splade-modal>
