<x-layouts.app>
    <x-layouts.contributions type="skill" label="skills Board"
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        {{-- <div class="grid grid-cols-1 gap-6 items-baseline max-h-full overflow-y-auto p-6"> --}}
        @forelse ($publicSkills as $skill)
            <x-layouts.skill :skill="$skill" class="grow-1" />
        @empty
            <div class="text-xl flex gap-5 flex-col items.center justify-center">
                <p class="text-center">No published skill for now.</p>
                @if (!auth()->check())
                    <x-layouts.navigation-link class="mx-auto" type="call-to-action" resource="login"
                        label="Login and start contributing"
                        icon-path="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                @endif
            </div>
        @endforelse
        {{-- </div> --}}

        @if (auth()->check())
            <x-splade-form :action="route('contribution.skill.store')" class="flex flex-col gap-6">
                <h1 class="text-xl">🙂 Add a new skill</h1>
                <x-splade-input name="title" label="Skill" />
                <x-splade-select name="topic_group_covering_it" label="group" :options="\App\Enums\TopicGroup::asOptions()" />
                <x-splade-select name="fields_covered_by_it" label="fields" :options="\App\Enums\TopicField::asOptions()" multiple />
                <x-splade-select name="years_levels_covering_it" label="years" :options="\App\Enums\YearLevel::asOptions()" multiple />
                <x-splade-submit>Submit</x-splade-submit>
            </x-splade-form>
        @endif
    </x-layouts.contributions>
</x-layouts.app>
