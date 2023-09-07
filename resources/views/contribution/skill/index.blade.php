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
                        </tr>
                    @endforeach
                </x-slot>
            @endif
        </x-splade-table>

    </x-layouts.contributions>
</x-layouts.app>
