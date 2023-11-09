<x-layouts.app active-page="Edit Checkpoint">
    <div class="h-full overflow-y-auto relative px-6 lg:px-80 md:px-20 pb-6">
        <x-splade-form :action="route('checkpoints.update', $checkpoint)" method="patch" :default="[
            'clozes' => $clozes,
            'flashCards' => $flashCards,
            'title' => $checkpoint->title,
        ]">
            <x-forms.checkpoint :$rq />
        </x-splade-form>
    </div>
</x-layouts.app>
