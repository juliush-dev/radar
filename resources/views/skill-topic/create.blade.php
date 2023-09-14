<x-layouts.app>
    <x-splade-modal>
        <div class="relative bg-slate-800 p-6 min-h-screen shadow-md shadow-emerald-500">
            <x-skill :skill="$skill" />
            <x-splade-form action="{{ route('skill-topic.store', $skill) }}" class="flex flex-col gap-8">
                <x-splade-group name="topics" label="choose the topics to add to this skill">
                    @foreach ($topicsOptions as $option)
                        <x-splade-checkbox name="topics[]" :value="$option->id" :label="$option->contribution->title" />
                    @endforeach
                </x-splade-group>
                <div class="flex justify-end  absolute bottom-0 right-0 p-8">
                    <x-splade-submit label="Confirm selection" />
                </div>
            </x-splade-form>
        </div>
    </x-splade-modal>
</x-layouts.app>
