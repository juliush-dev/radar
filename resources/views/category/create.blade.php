<x-layouts.app>
    <x-splade-modal close-explicitly :close-button="false" class="bg-white dark:bg-slate-800 dark:text-slate-400">
        <x-splade-form action="{{ route('categories.store', $note) }}" method="post" :default="[
            'name' => '',
        ]"
            class="flex flex-col gap-3 p-6">
            <label class="flex flex-col gap-2 justify-start">
                New Category
                <input type="text" class="h-8 border-fuchsia-400 rounded" v-model="form.name">
            </label>
            <button type="submit"
                class="text-white w-fit px-2 py-1 bg-fuchsia-400 hover:bg-fuchsia-500 transition-all duration-300 rounded">
                Add
            </button>
            <button
                class="rounded fixed top-4 right-6 bg-sky-400 hover:bg-sky-500 transition-all duration-75 px-2 py-1 text-white"
                @click.prevent="modal.close">Cancel</button>
        </x-splade-form>
    </x-splade-modal>
</x-layouts.app>
