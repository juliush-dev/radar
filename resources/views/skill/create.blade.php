<x-layouts.app active-page="New Skill">
    <div class="h-full overflow-y-auto relative px-6 lg:px-80 md:px-60 pb-6">
        <x-splade-form :action="route('skills.store')" :default="[
            'newGroup' => null,
        ]">
            <x-forms.skill :$rq />
        </x-splade-form>
    </div>
</x-layouts.app>
