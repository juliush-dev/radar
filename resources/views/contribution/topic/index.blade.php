<x-layouts.app>
    <x-layouts.contributions type="topic" label="topics" action-label="Submit a new topic"
        action-icon="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z">
        <x-splade-table :for="$contributedTopics" pagination-scroll="head">
            <x-slot:empty-state>
                <p class="p-6">No Contributions found!</p>
            </x-slot>
            @if ($component->for->resource->count() > 0)
                <x-slot name="body">
                    @foreach ($component->for->resource as $r)
                        <tr class="border-b border-emerald-900">
                            <td class="p-6">{{ $r->contribution->title }}</td>
                            <td class="p-6">{{ $r->years_teached_at }}</td>
                            <td class="p-6">{{ $r->topic_field }}</td>
                            <td class="p-6">
                                @if ($r->subjectCoveringIt)
                                    <x-splade-dropdown>
                                        <x-slot:trigger>
                                            <x-splade-button type="button"
                                                class="flex relative items-center justify-center">
                                                {{ $r->subjectCoveringIt->subject->contribution->title }}
                                            </x-splade-button>
                                        </x-slot>

                                        <div
                                            class="whitespace-nowrap shadow-md bg-slate-800 p-4 rounded-md flex flex-col gap-4">
                                            <x-layouts.navigation-link open-as='slideover' resource="topic-subject"
                                                action="edit" :action-args="$r->subjectCoveringIt" class="w-full" label="Change"
                                                type="call-to-action"
                                                icon-path="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />

                                            <x-layouts.navigation-link open-as='slideover' resource="topic-subject"
                                                action="create" :action-args="$r" class="w-full" label="Unlink subject"
                                                type="call-to-action"
                                                icon-path="M7.848 8.25l1.536.887M7.848 8.25a3 3 0 11-5.196-3 3 3 0 015.196 3zm1.536.887a2.165 2.165 0 011.083 1.839c.005.351.054.695.14 1.024M9.384 9.137l2.077 1.199M7.848 15.75l1.536-.887m-1.536.887a3 3 0 11-5.196 3 3 3 0 015.196-3zm1.536-.887a2.165 2.165 0 001.083-1.838c.005-.352.054-.695.14-1.025m-1.223 2.863l2.077-1.199m0-3.328a4.323 4.323 0 012.068-1.379l5.325-1.628a4.5 4.5 0 012.48-.044l.803.215-7.794 4.5m-2.882-1.664A4.331 4.331 0 0010.607 12m3.736 0l7.794 4.5-.802.215a4.5 4.5 0 01-2.48-.043l-5.326-1.629a4.324 4.324 0 01-2.068-1.379M14.343 12l-2.882 1.664" />
                                        </div>
                                    </x-splade-dropdown>
                                @else
                                    <x-layouts.navigation-link open-as="slideover" type="call-to-action"
                                        resource="topic-subject" :action-args="$r" action="create"
                                        label="None. Link one."
                                        icon-path="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                @endif
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
