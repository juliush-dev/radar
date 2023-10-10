<x-layouts.app active-page="Edit Skill" icon="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z">
    <div class="h-full overflow-y-auto relative px-6 lg:px-80 md:px-20 pb-6">
        <x-splade-form :action="route('skills.update', $skill)" method="patch" :default="[
            'title' => $skill->title,
            'type' => $skill->type_id,
            'years' => $skill->years->pluck('year'),
            'group' => $skill->group_id,
            'fields' => $rq->fields(['ids' => $skill->fields->pluck('field_id')->all()])->pluck('id'),
            'newGroup' => null,
        ]">
            <x-forms.skill :$rq :$skill />
        </x-splade-form>
    </div>
</x-layouts.app>
