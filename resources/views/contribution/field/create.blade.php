<x-layouts.app>
    <x-splade-modal close-explicitly class="shadow-md p-6 max-w-md mx-auto">
        <h1 class="text-2xl mb-8 first-letter:uppercase flex items.center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 my-auto">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            New Year
        </h1>
        <x-splade-form :action="route('contributions.fields.store')" class="flex flex-col gap-6">
            <x-splade-input name="title" label="Label" />
            <x-splade-select class="text-slate-800 first-letter:uppercase" label="years" name="years"
                :options="\App\Models\Year::all()->pluck('label', 'id')" multiple />
            <div class="flex justify-end">
                <x-splade-submit>Submit it</x-splade-submit>
            </div>
        </x-splade-form>
    </x-splade-modal>
</x-layouts.app>
