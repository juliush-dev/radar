<x-layouts.app>
    <x-splade-modal close-explicitly :close-button="false">
        <x-layouts.modal-content-wrapper>
            <x-splade-form action="{{ route('categories.destroy', $note) }}" method="delete" :default="[
                'selected' => [],
            ]"
                confirm-danger="Delete requested" confirm-text="The selected categories will be permanently deleted"
                confirm-button="Yes, delete the selected categories permanently" cancel-button="No don't delete"
                class="flex flex-col gap-2 p-6 font-medium">
                <ul class="flex flex-col gap-2">
                    @foreach ($categoriesOptions as $category)
                        <li>
                            <label class="flex gap-2">
                                <input type="checkbox" v-model="form.selected" value="{{ $category['id'] }}">
                                <span class="-mt-1">{{ $category['name'] }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
                <button type="submit"
                    class="text-white w-fit px-2 py-1 bg-fuchsia-400 hover:bg-fuchsia-500 transition-all duration-300 rounded">
                    Delete selected
                </button>
            </x-splade-form>
            <button
                class="rounded fixed top-4 right-6 bg-sky-400 hover:bg-sky-500 transition-all duration-75 px-2 py-1 text-white"
                @click.prevent="modal.close">Cancel</button>
        </x-layouts.modal-content-wrapper>
    </x-splade-modal>
</x-layouts.app>
