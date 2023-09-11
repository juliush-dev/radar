<x-layouts.app>
    <x-splade-modal max-width="2xl">
        <div class="bg-slate-800 p-6 min-h-screen shadow-md shadow-teal-500">
            <x-layouts.skill :skill="$skill" />
            <x-splade-form action="{{ route('skill-requirement.store', $skill) }}" class="flex flex-col gap-8">
                <x-splade-group name="topics" label="choose the topics to add to this skill">
                    @foreach ($topicsOptions as $option)
                        <x-splade-checkbox name="topics[]" :value="$option->id" :label="$option->contribution->title" />
                    @endforeach
                </x-splade-group>
                <div class="flex justify-end mt-5">
                    <x-splade-submit label="Confirm selection" />
                </div>
            </x-splade-form>
        </div>
    </x-splade-modal>
</x-layouts.app>
