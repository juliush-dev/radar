<x-layouts.app>
    <x-splade-modal close-explicitly class="shadow-md p-6 max-w-md mx-auto">
        <h1 class="text-xl mb-8 first-letter:uppercase flex items.center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            </svg>
            Update Skill
        </h1>
        @php
            $topics = $skill->skillTopics->map(fn($skillTopic) => $skillTopic->topic)->reduce(function ($acc, $topic) {
                array_push($acc, [
                    'id' => $topic->id,
                    'title' => $topic->contribution->title,
                ]);
                return $acc;
            }, []);
        @endphp
        <x-splade-form method="patch" :action="route('contributions.skills.update', $skill)" :default="[
            'title' => $skill->contribution->title,
            'topic_group_covering_it' => $skill->topic_group_covering_it,
            'fields_covered_by_it' => explode(',', $skill->fields_covered_by_it),
            'years_levels_covering_it' => explode(',', $skill->years_levels_covering_it),
            'topics' => $topics,
        ]" class="flex flex-col gap-8">
            <x-splade-input name="title" label="Skill" placeholder="New Title" />
            <x-splade-select class="text-slate-800" label="Group" name="topic_group_covering_it" :options="$groupsOptions" />
            <x-splade-select label="Fields" name="fields_covered_by_it" :options="$fieldsOptions" multiple />
            <x-splade-select label="Years" name="years_levels_covering_it" :options="$yearsOptions" multiple />
            <x-splade-select label="New topics" name="topics" :remote-url="'`' .
                route('topics.options', $skill) .
                '?fields=${form.fields_covered_by_it.length > 0 ? form.fields_covered_by_it : 0}&years=${form.years_levels_covering_it.length > 0 ? form.years_levels_covering_it : 0}`'"
                placeholder="No matching topics selected" option-value="id" option-label="title" multiple />
            <div class="flex justify-end mt-5">
                <x-splade-submit label="Save" />
            </div>
        </x-splade-form>
    </x-splade-modal>
</x-layouts.app>
