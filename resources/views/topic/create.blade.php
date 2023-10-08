<x-layouts.app active-page="New Topic">
    <div class="h-full overflow-y-auto relative px-6 lg:px-80 md:px-60 pb-6">
        <x-splade-form :action="route('topics.store')" :default="[
            'newSubject' => null,
            'newFields' => [],
            'newSkills' => [],
            'learningMaterials' => [],
            'routeOnSuccess' => $routeOnSuccess,
        ]">
            <x-forms.topic :$rq :route-on-cancel="$routeOnCancel" />
        </x-splade-form>
    </div>
</x-layouts.app>
