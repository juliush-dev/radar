<x-layouts.app active-page="New Checkpoint">
    <div class="h-full overflow-hidden overflow-y-auto relative px-6 lg:px-80 md:px-20 pb-6">
        <x-splade-form :action="route('checkpoints.store', $topic)" :default="[
            'clozes' => [],
            'flashCards' => [],
        ]">
            <x-forms.checkpoint :$rq />
        </x-splade-form>
    </div>
</x-layouts.app>
