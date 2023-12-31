<div v-show="@js($searchInput->value !== null) || table.isForcedVisible(@js($searchInput->key))" class="px-4 sm:px-0">
    <div class="flex shadow-sm relative mt-3">
        <label for="{{ $searchInput->key }}"
            class="inline-flex items-center px-4 border border-r-0 border-teal-500 bg-green-50 text-green-500 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd" />
            </svg>

            <span>{{ $searchInput->label }}</span>
        </label>

        <input name="searchInput-{{ $searchInput->key }}" value="{{ $searchInput->value }}" type="text"
            class="flex-1 min-w-0 block w-full px-3 py-2  focus:ring-emerald-500 focus:border-emerald-500 text-sm border-teal-500"
            v-bind:class="{ 'opacity-50': table.isLoading }" v-bind:disabled="table.isLoading"
            @input="table.debounceUpdateQuery('filter[{{ $searchInput->key }}]', $event.target.value, $event.target)" />

        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <button
                class=" text-teal-600 hover:text-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                @click.prevent="table.disableSearchInput(@js($searchInput->key))"
                dusk="remove-search-row-{{ $searchInput->key }}">
                <span class="sr-only">{{ __('Remove search') }}</span>

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
