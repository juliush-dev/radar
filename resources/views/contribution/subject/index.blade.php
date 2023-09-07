<x-layouts.app>
    <x-layouts.contributions type="subject" label="subjects" action-label="New subject"
        action-icon="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z">
        <x-splade-table :for="$contributedSubjects" pagination-scroll="head">
            <x-slot:empty-state>
                <p class="p-6">No Contributions found!</p>
            </x-slot>
            @if ($component->for->resource->count() > 0)
                <x-slot name="body">
                    @foreach ($component->for->resource as $r)
                        <tr class="border-b border-teal-900">
                            <td class="p-6">{{ $r->contribution->title }}</td>
                            <td class="p-6">{{ $r->description }}</td>
                            <td class="p-6">{{ $r->teacher->salutation }} {{ $r->teacher->name }}</td>
                            <td class="p-6">{{ $r->year_levels_covered_by_it }}</td>
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
