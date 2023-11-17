<x-layouts.app active-page="Edit Checkpoint">
    <div class="h-full overflow-y-auto relative px-6 lg:px-80 md:px-20 pb-6">
        <x-splade-form :action="route('checkpoints.update', $checkpoint)" method="patch" :default="[
            'title' => $title,
            'goal' => $goal,
            'knowledgeCubes' => $knowledgeCubes,
        ]">
            <x-forms.checkpoint :$rq />
        </x-splade-form>
    </div>
</x-layouts.app>
