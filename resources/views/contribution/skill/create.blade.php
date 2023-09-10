{{-- <x-layouts.app> --}}
<x-splade-modal max-width="2xl">
    <div class="bg-slate-800 p-6 min-h-screen shadow-md shadow-teal-500">
        <h1 class="text-2xl mb-8 first-letter:uppercase flex items.center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            </svg>
            New Skill
        </h1>
        <x-splade-form action="{{ route('contribution.skill.store') }}" class="flex flex-col gap-8">
            <x-splade-input name="title" label="Title" placeholder="The student should be able to ..." />
            <x-splade-select label="Years of the training covering it" name="years_levels_covering_it" :options="$yearsLevelsOptions"
                multiple />
            <x-splade-select class="text-slate-800" label="Topic group covering it" name="topic_group_covering_it"
                :options="$topicGroupsOptions" />
            <x-splade-select label="Fields of the training covered by it" name="fields_covered_by_it" :options="$topicFieldsOptions"
                multiple />

            <div class="flex justify-end mt-5">
                <x-splade-submit label="Submit it" />
            </div>
        </x-splade-form>
    </div>
</x-splade-modal>
{{-- </x-layouts.app> --}}
