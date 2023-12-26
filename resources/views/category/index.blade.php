<x-layouts.app>
    <x-splade-modal close-explicitly :close-button="false">
        <x-layouts.modal-content-wrapper>
            <ul class="flex flex-col gap-6 p-6 font-medium">
                @foreach ($categoriesOptions as $category)
                    <li>
                        <x-splade-form
                            action="{{ route('categories.update', ['category' => $category['id'], 'note' => $note]) }}"
                            method="patch" :default="[
                                'name' => $category['name'],
                            ]" stay background submit-on-change class="flex flex-col gap-2">
                            <label>{{ $category['name'] }}</label>
                            <input type="text" class="h-8 border-fuchsia-400 rounded" v-model="form.name">
                        </x-splade-form>
                    </li>
                @endforeach
            </ul>
            <Link href="{{ route('notes.edit', $note) }}"
                class="rounded fixed top-4 right-6 bg-sky-400 hover:bg-sky-500 transition-all duration-75 px-2 py-1 text-white"
                @click.prevent="modal.close">Done</Link>
        </x-layouts.modal-content-wrapper>
    </x-splade-modal>
</x-layouts.app>
