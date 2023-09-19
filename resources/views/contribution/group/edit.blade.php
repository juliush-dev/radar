<x-layouts.app>
    <x-splade-modal close-explicitly class="shadow-md p-6 max-w-md mx-auto">
        <h1 class="text-2xl mb-8 first-letter:uppercase flex items.center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
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
