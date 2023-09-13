<x-layouts.app>
    <x-splade-modal>
        <div class="relative bg-slate-800 p-6 min-h-screen shadow-md shadow-emerald-500">
            <x-layouts.skill :skill="$skill" class="mb-5" />
            <x-splade-form action="{{ route('skill-requirement.delete') }}" class="flex flex-col gap-8">
                <x-splade-group name="skills_requirements" label="choose the topics to remove from the list">
                    <div class="mb-8 flex gap-4">
                        <span>Or</span>
                        <x-layouts.navigation-link open-as='slideover' resource="skill-requirement" action="create"
                            :action-args="$skill" label="Select more topics" icon-path="" />
                    </div>
                    @foreach ($requiredTopics as $requiredTopic)
                        @php
                            $idValue = $requiredTopic
                                ->skillsRequiringIt()
                                ->where('skill_id', $skill->id)
                                ->first()->id;
                        @endphp
                        <x-splade-checkbox name="skills_requirements[]" :value="$idValue" :label="$requiredTopic->contribution->title" />
                    @endforeach
                </x-splade-group>
                <div class="whitespace-nowrap absolute bottom-0 right-0 p-8 flex gap-5">
                    <x-layouts.navigation-link open-as='slideover' resource="skill-requirement" action="create"
                        :action-args="$skill" label="Remove selected" type="call-to-action"
                        icon-path="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </div>
            </x-splade-form>
        </div>
    </x-splade-modal>
</x-layouts.app>
