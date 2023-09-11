<x-layouts.app>
    <x-layouts.contributions type="skill" label="skills" action-label="New skill"
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        <x-splade-table :for="$contributedSkills" pagination-scroll="head">
            <x-slot:empty-state>
                <p class="p-6">No Contributions found!</p>
            </x-slot>
            @if ($component->for->resource->count() > 0)
                <x-slot name="body">
                    @foreach ($component->for->resource as $r)
                        <tr class="border-b border-teal-900">
                            <td class="p-6">{{ $r->contribution->title }}</td>
                            <td class="p-6">{{ $r->topic_group_covering_it }}</td>
                            <td class="p-6">{{ $r->years_levels_covering_it }}</td>
                            <td class="p-6">{{ $r->fields_covered_by_it }}</td>
                            @php
                                $visibility = $r->contribution->visibility;
                                $visibilityEnum = App\Enums\Visibility::class;
                                $visibilityClass = '';
                                switch ($visibility) {
                                    case $visibilityEnum::Public->value:
                                        $visibilityClass = 'text-teal-300';
                                        break;
                                    case $visibility::Private->value:
                                        $visibilityClass = 'text-amber-300';
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
                                        $modificationRequestStateClass = 'text-teal-300';
                                        break;
                                    case $modificatonStateEnum::Pending->value:
                                        $modificationRequestStateClass = 'text-yellow-300';
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
                                        <x-layouts.navigation-link open-as='slideover' resource="skill-requirement"
                                            action="index" :action-args="$r" label="Topics teaching this skill"
                                            icon-path="M7.875 14.25l1.214 1.942a2.25 2.25 0 001.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 011.872 1.002l.164.246a2.25 2.25 0 001.872 1.002h2.092a2.25 2.25 0 001.872-1.002l.164-.246A2.25 2.25 0 0116.954 9h4.636M2.41 9a2.25 2.25 0 00-.16.832V12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 01.382-.632l3.285-3.832a2.25 2.25 0 011.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0021.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 002.25 2.25z" />
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
