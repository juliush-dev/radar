<x-layouts.app>
    <x-layouts.contributions type="skill" label="skills"
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        <x-layouts.navigation-link open-as="modal" type="call-to-action" resource="contribution.skill" action="create"
            label="Submit new skill"
            icon-path="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
            class="ml-auto" />
        <x-splade-table :for="$contributedSkills" pagination-scroll="head">
            <x-slot:empty-state>
                <p class="p-6">No Contributions found!</p>
            </x-slot>
            @if ($component->for->resource->count() > 0)
                <x-slot name="body">
                    @foreach ($component->for->resource as $r)
                        <tr class="border-b border-emerald-900">
                            <td class="p-6">{{ $r->contribution->title }}</td>
                            <td class="p-6">{{ $r->topic_group_covering_it }}</td>
                            <td class="p-6">{{ $r->years_levels_covering_it }}</td>
                            <td class="p-6">{{ $r->fields_covered_by_it }}</td>
                            <td class="p-6">
                                <x-layouts.navigation-link open-as='modal' resource="skill-topic" action="index"
                                    :action-args="$r" label="{{ $r->skillTopics->count() }} Topics"
                                    icon-path="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.5 3c.967 2.78 1.5 5.817 1.5 9s-.533 6.22-1.5 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.889m-8.25.75l.213.09a1.687 1.687 0 002.062-.617l4.45-6.676a1.688 1.688 0 012.062-.618l.213.09" />
                            </td>
                            @php
                                $visibility = $r->contribution->visibility;
                                $visibilityEnum = App\Enums\Visibility::class;
                                $visibilityClass = '';
                                switch ($visibility) {
                                    case $visibilityEnum::Public->value:
                                        $visibilityClass = 'text-teal-600';
                                        break;
                                    case $visibility::Private->value:
                                        $visibilityClass = 'text-teal-600';
                                        break;
                                    case $visibility::Disabled->value:
                                        $visibilityClass = 'text-red-300';
                                        break;
                                }
                            @endphp
                            <td class="p-6 capitalize {{ $visibilityClass }}">
                                {{ $visibility }}
                            </td>
                            @php
                                $modificationType = $r->contribution
                                    ->modificationRequests()
                                    ->latest()
                                    ->first()->modification_type;
                                $create = $modificationType == App\Enums\ModificationType::Create->value;
                                $delete = $modificationType == App\Enums\ModificationType::Delete->value;
                                $update = $modificationType == App\Enums\ModificationType::Update->value;
                            @endphp
                            <td class="p-6 capitalize">
                                {{ $modificationType }}
                            </td>
                            @php

                                $modificationRequestState = $r->contribution
                                    ->modificationRequests()
                                    ->latest()
                                    ->first()->modification_request_state;
                                $modificatonStateEnum = App\Enums\ModificationRequestState::class;
                                $modificationRequestStateClass = '';
                                switch ($modificationRequestState) {
                                    case $modificatonStateEnum::Approved->value:
                                        $modificationRequestStateClass = 'text-teal-600';
                                        break;
                                    case $modificatonStateEnum::Pending->value:
                                        $modificationRequestStateClass = 'text-yellow-600';
                                        break;
                                }
                            @endphp
                            <td class="p-6 capitalize {{ $modificationRequestStateClass }}">
                                {{ $modificationRequestState }}
                            </td>
                            <td class="p-6 capitalize">
                                <x-splade-dropdown>
                                    <x-slot:trigger>
                                        <x-splade-button type="button"
                                            class="h-4 w-7 flex relative items-center justify-center">
                                            <span class="absolute top-0.5 left-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                </svg>
                                            </span>
                                        </x-splade-button>
                                    </x-slot>

                                    <div class="whitespace-nowrap shadow-md bg-slate-800 p-4 rounded-md">
                                        <x-layouts.navigation-link open-as='slideover' resource="skill-topic"
                                            action="create" :action-args="$r" label="Select required topics"
                                            type="call-to-action"
                                            icon-path="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.5 3c.967 2.78 1.5 5.817 1.5 9s-.533 6.22-1.5 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.889m-8.25.75l.213.09a1.687 1.687 0 002.062-.617l4.45-6.676a1.688 1.688 0 012.062-.618l.213.09" />
                                    </div>
                                </x-splade-dropdown>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            @endif
        </x-splade-table>
    </x-layouts.contributions>
</x-layouts.app>
