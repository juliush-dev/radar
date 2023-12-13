<x-layouts.app active-page="New Skill">
    <div>
        <x-splade-form :action="route('skills.store')" :default="[
            'newGroup' => null,
        ]">
            <x-forms.skill :$rq />
        </x-splade-form>
    </div>
</x-layouts.app>
