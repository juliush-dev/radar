<x-layouts.app>
    <x-splade-modal close-explicitly class="shadow-md p-6 max-w-md mx-auto">
        <h1 class="text-2xl mb-8 first-letter:uppercase flex items.center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            </svg>
            Edit Topic
        </h1>
        <x-splade-form method="patch" :action="route('contributions.topics.update', $topic)" :default="[
            'title' => $topic->contribution->title,
            'year_teached_at' => $topic->year_teached_at,
            'topic_field' => $topic->topic_field,
            'subject' => $topic->subjectCoveringIt,
        ]" class="flex flex-col gap-8">
            <x-splade-input name="title" label="Topic" />
            <x-splade-select name="year_teached_at" :options="$yearsOptions" label="Year" />
            <x-splade-select name="topic_field" :options="$fieldsOptions" label="Field" />
            <x-splade-select label="subject" name="subject" :remote-url="'`' .
                route('subjects.options', $topic) .
                '?year=${form.year_teached_at.length > 0 ? form.year_teached_at : 0}`'" reset-on-new-remote-url option-value="id"
                option-label="title" placeholder="Try to select a subject, if any matching" />
            <div class="flex justify-end">
                <x-splade-submit>Save</x-splade-submit>
            </div>
        </x-splade-form>
    </x-splade-modal>
</x-layouts.app>
