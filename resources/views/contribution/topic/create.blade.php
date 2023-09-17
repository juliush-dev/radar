<x-layouts.app>
    <x-splade-modal close-explicitly class="shadow-md p-6 max-w-md mx-auto">
        <h1 class="text-2xl mb-8 first-letter:uppercase flex items.center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            </svg>
            New Topic
        </h1>
        <x-splade-form :action="route('contributions.topics.store')" class="flex flex-col gap-6">
            <x-splade-input name="title" label="Topic" />
            <x-splade-select name="year_teached_at" :options="$yearsLevelsOptions" label="Year" />
            <x-splade-select name="topic_field" :options="$topicFieldsOptions" label="Field" />

            <x-splade-select label="subject" name="subject" :remote-url="'`' .
                route('subjects.options') .
                '?year=${form.year_teached_at.length > 0 ? form.year_teached_at : 0}`'" reset-on-new-remote-url option-value="id"
                option-label="title" placeholder="No matching subject selected" />
            <p class="p-4 flex gap-2 items-center border border-slate-200 rounded-md">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </span>
                <span class="text-sm">
                    Matching subjects are those which year matches one of that of the topic.
                    If no matching subject is found, you can still create the
                    topic. You can create a subject later and add it to this topic.
                </span>
            </p>
            <div class="flex justify-end">
                <x-splade-submit>Submit it</x-splade-submit>
            </div>
        </x-splade-form>
    </x-splade-modal>
</x-layouts.app>
