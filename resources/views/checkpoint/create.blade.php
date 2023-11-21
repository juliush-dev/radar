<x-layouts.app :active-page="$topic->title . ' / New Checkpoint'">
    <div class="h-full overflow-hidden overflow-y-auto relative px-6 lg:px-80 md:px-20 pb-6">
        <x-splade-form :action="route('checkpoints.store', $topic)">
            <x-forms.checkpoint :$topic />
        </x-splade-form>
    </div>
</x-layouts.app>
