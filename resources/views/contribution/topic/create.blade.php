<x-layouts.app>
    <x-splade-modal class="shadow-md p-6">
        <h1 class="text-2xl mb-8 first-letter:uppercase flex items.center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
            </svg>
            New Topic
        </h1>
        <x-topic-form :action="route('contribution.topic.store')" :years-options="$yearsLevelsOptions" :fields-options="$topicFieldsOptions" :subjects-options="$publicSubjects" />
    </x-splade-modal>
</x-layouts.app>
