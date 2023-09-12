<x-layouts.app>
    <x-splade-modal>
        <div class="bg-slate-800 p-6 min-h-screen shadow-md shadow-teal-500">
            <h1 class="text-2xl mb-8 first-letter:uppercase flex items.center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                </svg>
                New Subject
            </h1>
            <x-splade-form action="{{ route('contribution.subject.store') }}" class="flex flex-col gap-8">
                <x-splade-input name="title" label="Title" placeholder="SD1" />
                <x-splade-input name="description" label="Description" placeholder="A good description" />
                <x-splade-select class="text-slate-800" label="Year levels covered by this subject"
                    name="year_levels_covered_by_it" :options="$yearsLevelsOptions" multiple />
                <div class="flex justify-end mt-5">
                    <x-splade-submit label="Submit it" />
                </div>
            </x-splade-form>
        </div>
    </x-splade-modal>
</x-layouts.app>
