@php
    $categoriesOptions = \App\Models\Category::options($filter['categories'] ?? []);
@endphp
<x-splade-modal slideover close-explicitly :close-button="false" name="notes-filter">
    <x-layouts.modal-content-wrapper>
        <x-splade-form action="{{ route('notes.filter') }}" method="get" preserve-scroll :default="[
            'categories' => $filter['categories'] ?? [],
        ]">
            <ul class="flex flex-col gap-6 mb-6 p-8">
                @foreach ($categoriesOptions as $categoryOption)
                    <li>
                        <label class="flex gap-2 items-center">
                            <input type="checkbox" class="rounded border-fuchsia-200" v-model="form.categories"
                                value="{{ $categoryOption['id'] }}">
                            <span class="soft mt-1"><span
                                    class="font-medium text-lg">{{ $categoryOption['name'] }}</span></span>
                        </label>
                    </li>
                @endforeach
            </ul>
            <button type="submit"
                class="rounded fixed top-4 right-6 bg-sky-400 hover:bg-sky-500 transition-all duration-75 px-2 py-1 text-white"
                @click="modal.close">Done</button>
        </x-splade-form>
    </x-layouts.modal-content-wrapper>
</x-splade-modal>

<x-splade-form action="{{ route('notes.filter') }}" method="get" :default="[
    'categories' => $filter['categories'] ?? [],
]" submit-on-change
    class="hidden lg:block lg:flex-col lg:fixed lg:left-0 lg:w-[18rem] lg:border-r border-slate-400/30 lg:px-6 py-[1px] lg:top-7 lg:bottom-0 lg:pt-10 lg:overflow-y-auto lg:pb-4">
    <h3 class="text-lg font-semibold  mb-6">Notes by categories</h3>
    <ul class="flex flex-col gap-6" @preserveScroll('NotesFilter')>
        @foreach ($categoriesOptions as $categoryOption)
            <li>
                <label class="flex gap-2">
                    <input type="checkbox" class="rounded border-fuchsia-200" v-model="form.categories"
                        value="{{ $categoryOption['id'] }}">
                    <span class="soft -mt-1"><span
                            class="font-medium text-lg">{{ $categoryOption['name'] }}</span></span>
                </label>
            </li>
        @endforeach
    </ul>
</x-splade-form>
