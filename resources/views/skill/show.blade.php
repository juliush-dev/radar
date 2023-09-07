<x-layouts.app>
    <x-layouts.main-content label="Skills Board" type="skill" actionLabel="Submit a new skill"
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        <x-layouts.skill :skill="$skill" />
        <div class="absolute bottom-0 right-0 p-8">
            <x-layouts.navigation-link open-as="slideover" type="call-to-action" resource="topic" action="create"
                :action-args="$skill" label="Add topic"
                icon-path="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.5 3c.967 2.78 1.5 5.817 1.5 9s-.533 6.22-1.5 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.889m-8.25.75l.213.09a1.687 1.687 0 002.062-.617l4.45-6.676a1.688 1.688 0 012.062-.618l.213.09" />
        </div>
    </x-layouts.main-content>
</x-layouts.app>
