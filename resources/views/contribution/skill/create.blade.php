<x-layouts.app>
    <x-splade-modal close-explicitly class="shadow-md p-6 max-w-md max-h-full mx-auto my-auto overflow-hidden">
        <h1 class="text-xl mb-8 first-letter:uppercase flex items.center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            </svg>
            New Skill
        </h1>
        <div class="overflow-auto pr-4">
            <x-splade-form :action="route('contributions.skills.store')" class="flex flex-col gap-8">
                <x-splade-input name="title" label="Skill" placeholder="The student should be able to ..." />
                <x-splade-select class="text-slate-800" label="Group" name="topic_group_covering_it"
                    :options="$groupsOptions" />
                <x-splade-select label="Fields" name="fields_covered_by_it" :options="$fieldsOptions" multiple />
                <x-splade-select label="Years" name="years_levels_covering_it" :options="$yearsOptions" multiple />
                <x-splade-select label="topics" name="topics" :remote-url="'`' .
                    route('topics.options') .
                    '?fields=${form.fields_covered_by_it.length > 0 ? form.fields_covered_by_it : 0}&years=${form.years_levels_covering_it.length > 0 ? form.years_levels_covering_it : 0}`'" reset-on-new-remote-url
                    option-value="id" option-label="title" placeholder="No matching topics selected" multiple />
                <p class="p-4 flex gap-2 items-center border border-slate-200 rounded-md">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </span>
                    <span class="text-sm">
                        Matching topics are those which year and field match one of that of the skill.
                        If no matching topic is found, you can still create the
                        skill. You can create some topics later and add them to it.
                    </span>
                </p>
                <div class="flex justify-end mt-5">
                    <x-splade-submit label="Submit it" />
                </div>
            </x-splade-form>
        </div>
    </x-splade-modal>
</x-layouts.app>
