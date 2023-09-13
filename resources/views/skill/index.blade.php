<x-layouts.app>
    <x-layouts.contributions type="skill" label="skills Board"
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        <x-splade-data
            default="{ focusedSkill:null, focusedTopic:null, addingNewtopic:null, addingNewLearningMaterial:null}">
            {{-- <div class="grid grid-cols-1 gap-6 items-baseline max-h-full overflow-y-auto p-6"> --}}
            @foreach ($publicSkills as $skill)
                <x-layouts.skill :skill="$skill" class="grow-1" />
            @endforeach
            {{-- </div> --}}

            <x-splade-transition show="data.focusedSkill == null" animation="slide-right">
                <div class="flex gap-5 p-6 justify-end">
                    @if ($publicSkills->count() == 0)
                        <p class="text-xl w-full justify-center bg-slate-200 flex items-center p-6 self-stretch">No
                            published
                            skill
                            for now.</p>
                    @endif
                    <x-splade-form :action="route('contribution.skill.store')" class="flex flex-col gap-6  w-96 m-auto">
                        <h1 class="text-xl">🙂 Want to add a new skill?</h1>
                        <x-splade-input name="title" label="Skill" />
                        <x-splade-select name="topic_group_covering_it" label="group" :options="\App\Enums\TopicGroup::asOptions()" />
                        <x-splade-select name="fields_covered_by_it" label="fields" :options="\App\Enums\TopicField::asOptions()" multiple />
                        <x-splade-select name="years_levels_covering_it" label="years" :options="\App\Enums\YearLevel::asOptions()" multiple />
                        <x-splade-submit>Submit</x-splade-submit>
                    </x-splade-form>
                </div>
            </x-splade-transition>
        </x-splade-data>
    </x-layouts.contributions>
</x-layouts.app>
