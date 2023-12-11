@php
    $categories = $note->categories
        ->map(function ($category) {
            return ['id' => $category->id, 'name' => $category->name];
        })
        ->all();
@endphp
<x-layouts.app>
    <x-splade-modal close-explicitly :close-button="false" class="bg-white dark:bg-slate-800 dark:text-slate-400">
        <x-splade-form action="{{ route('notes.categorize', $note) }}" method="post" :default="[
            'categories' => $categories,
        ]">
            <ul class="flex flex-col gap-6 p-6">
                @foreach ($categoriesOptions as $category)
                    <label class="flex gap-2">
                        <input type="checkbox" v-model="form.categories" :value="@js($category)">
                        <span class="-mt-1">{{ $category['name'] }}</span>
                    </label>
                @endforeach
            </ul>
            <button
                class="rounded fixed top-4 right-6 bg-sky-400 hover:bg-sky-500 transition-all duration-75 px-2 py-1 text-white"
                type="submit" @click="modal.close">Done</button>
        </x-splade-form>
    </x-splade-modal>
</x-layouts.app>
