<x-layouts.app>
    <x-splade-modal max-width="2xl" class="shadow-md shadow-teal-400 bg-stone-950/60">
        <div>
            <h1 class="text-xl mb-8 first-letter:uppercase flex items.center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                New Teacher
            </h1>
            <x-splade-form action="{{ route('subject.store') }}" class="flex flex-col gap-8">
                <x-splade-input name="title" label="Title" placeholder="SD1" />
                <x-splade-input name="description" label="Title" placeholder="Software development" />
                <x-splade-select label="Which years of the training cover this subject?"
                    name="year_levels_covered_by_it" :options="$yearsLevelsOptions" multiple />
                <x-splade-select label="Teacher" name="teacher_id" option-value="id" option-label="name"
                    :options="$teachers" placeholder="Delva" />
                <x-splade-select class="text-slate-800" label="Decide for the visibility of this contribution"
                    name="modification_type" :options="$modificationsTypesOptions" />
                <div class="flex justify-end mt-5">
                    <x-splade-submit label="Submit it" />
                </div>
            </x-splade-form>
        </div>
    </x-splade-modal>
</x-layouts.app>
