<x-layouts.app active-page="New Checkpoint">
    <div class="h-full overflow-hidden overflow-y-auto relative px-6 lg:px-80 md:px-20 pb-6">
        <x-splade-form :action="route('checkpoints.store', $topic)" :default="[
            'title' => '',
            'knowledgeCubes' => [],
        ]">
            <x-forms.checkpoint />
        </x-splade-form>
    </div>
</x-layouts.app>
