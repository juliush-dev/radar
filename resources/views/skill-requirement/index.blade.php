<x-layouts.app>
    <x-splade-modal max-width="2xl">
        <x-splade-rehydrate on="team-member-added">
            <div class="bg-slate-800 p-6 min-h-screen shadow-md shadow-teal-500">
                <x-layouts.skill :skill="$skill" class="mb-5" />
                <x-splade-form action="{{ route('skill-requirement.store', $skill) }}" submit-on-change background
                    debounce="50" class="flex flex-col gap-8" stay @success="$splade.emit('team-member-added')">
                    <x-splade-group name="topics" label="the Selected topics are required by this skill"
                        class="text-2xl first-letter:uppercase">
                        <div class="flex flex-col gap-5">
                            <h3 class="text-xl">Allready selected topics</h3>
                            @foreach ($requiredTopics as $requiredTopic)
                                <x-splade-checkbox class="text-md" name="topics[]" :value="$requiredTopic->id" :label="$requiredTopic->contribution->title"
                                    checked />
                            @endforeach
                            <h3 class="text-xl">Topics you can select from</h3>
                            @foreach ($topicsOptions as $option)
                                <x-splade-checkbox class="text-md" name="topics[]" :value="$option->id"
                                    :label="$option->contribution->title" />
                            @endforeach
                        </div>
                    </x-splade-group>

                </x-splade-form>
            </div>
        </x-splade-rehydrate>
    </x-splade-modal>
</x-layouts.app>
