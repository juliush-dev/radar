<x-layouts.app>
    <x-splade-modal max-width="2xl">
        <div class="bg-slate-800 p-6 min-h-screen shadow-md shadow-teal-500">
            <x-layouts.skill :skill="$skill" class="mb-5" />
            <ul>
                @foreach ($requiredTopics as $requiredTopic)
                    <li class="mb-4">
                        <div class="flex gap-5 items-center">
                            <span class="text-xl">{{ $requiredTopic->contribution->title }}</span>
                            <x-layouts.navigation-link class="text-sm" resource="skill-requirement" action="delete"
                                :action-args="$requiredTopic" label="remove"
                                icon-path="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="whitespace-nowrap shadow-md bg-slate-800 p-4 rounded-md flex justify-end">
                <x-layouts.navigation-link open-as='slideover' resource="skill-requirement" action="create"
                    :action-args="$skill" label="Select more topics" type="call-to-action"
                    icon-path="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.5 3c.967 2.78 1.5 5.817 1.5 9s-.533 6.22-1.5 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.889m-8.25.75l.213.09a1.687 1.687 0 002.062-.617l4.45-6.676a1.688 1.688 0 012.062-.618l.213.09" />
            </div>
        </div>
    </x-splade-modal>
</x-layouts.app>
