<x-splade-component is="dropdown" dusk="select-rows-dropdown" close-on-click>
    <x-slot:trigger>
        <input type="checkbox"
            class="border-teal-500 text-teal-600 shadow-sm focus:border-teal-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 disabled:opacity-50"
            :checked="table.allVisibleItemsAreSelected" />
    </x-slot:trigger>

    <div class="mt-2 min-w-max shadow-lg bg-white ring-1 ring-black ring-opacity-5">
        <div class="flex flex-col">
            <button
                class="text-left w-full px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900 font-normal"
                @click="table.setSelectedItems(@js($table->getPrimaryKeys()))" dusk="select-all-on-this-page">
                {{ __('Select all on this page') }} ({{ $table->totalOnThisPage() }})
            </button>

            @if ($showPaginator())
                <button
                    class="text-left w-full px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900 font-normal"
                    @click="table.setSelectedItems(['*'])" dusk="select-all-results">
                    {{ __('Select all results') }} ({{ $table->totalOnAllPages() }})
                </button>
            @endif

            <button v-if="table.hasSelectedItems"
                class="text-left w-full px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900 font-normal"
                @click="table.setSelectedItems([])" dusk="select-none">
                {{ __('Clear selection') }}
            </button>
        </div>
    </div>
</x-splade-component>
