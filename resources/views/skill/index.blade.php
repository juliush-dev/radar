<x-layouts.app>
    <x-layouts.contributions label="Skills Board" type="skill" action-label="Submit a new skill"
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        <x-splade-data default="{ currentFocus:null}">

            <div class="grid grid-cols-1 gap-6 items-baseline max-h-full overflow-y-auto pr-6">
                @foreach ($publicSkills as $skill)
                    <x-layouts.skill :skill="$skill" class="grow-1" />
                @endforeach
            </div>
        </x-splade-data>
    </x-layouts.contributions>
</x-layouts.app>
