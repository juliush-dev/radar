<x-layouts.app>
    <x-layouts.contributions type="skill" label="skills Board"
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        @if ($skill == null || $skill->id == null)
            <x-topic :topic="$topic" class="grow-1" expanded="true" />
        @else
            <x-skill :skill="$skill" :focusedTopic="$topic" class="grow-1" expanded="true" />
        @endif
    </x-layouts.contributions>
</x-layouts.app>
