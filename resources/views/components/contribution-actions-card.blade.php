<x-splade-modal close-explicitly class="shadow-md p-6 pt-12 flex flex-col gap-4 max-w-xs mx-auto">
    <h1 class="text-xs border-b border-slate-400 p-4">{{ $model->contribution->title }}</h1>
    <x-layouts.navigation-link open-as="modal" class="grow" type="call-to-action" resource="{{ $resource }}"
        action="show" :action-args="$model" label="Open"
        icon-path="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />

    <x-layouts.navigation-link open-as="modal" class="grow" type="call-to-action"
        resource="contributions.{{ $resource }}" action="edit" :action-args="$model" label="Edit"
        icon-path="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
    @php
        $contribution = $model->contribution;
        $contributionState = $contribution->modificationRequests->first()->modification_request_state;
        $contributionVisibility = $contribution->visibility;
    @endphp
    @if (
        $contributionState == \App\Enums\ModificationRequestState::Pending->value ||
            $contributionState == \App\Enums\ModificationRequestState::Rejected->value)
        <x-layouts.navigation-link class="grow" type="call-to-action" resource="contributions" action="approve"
            :action-args="$contribution" label="Approve" icon-path="M4.5 12.75l6 6 9-13.5" />
    @else
        <x-layouts.navigation-link class="grow" type="call-to-action" resource="contributions" action="reject"
            :action-args="$contribution" label="Reject" icon-path="M6 18L18 6M6 6l12 12" />
    @endif
    @if ($contributionVisibility == \App\Enums\Visibility::Public->value)
        <x-layouts.navigation-link class="grow" type="call-to-action" resource="contributions" action="hide"
            :action-args="$contribution" label="Hide"
            icon-path="M3 3l8.735 8.735m0 0a.374.374 0 11.53.53m-.53-.53l.53.53m0 0L21 21M14.652 9.348a3.75 3.75 0 010 5.304m2.121-7.425a6.75 6.75 0 010 9.546m2.121-11.667c3.808 3.807 3.808 9.98 0 13.788m-9.546-4.242a3.733 3.733 0 01-1.06-2.122m-1.061 4.243a6.75 6.75 0 01-1.625-6.929m-.496 9.05c-3.068-3.067-3.664-7.67-1.79-11.334M12 12h.008v.008H12V12z" />
    @else
        <x-layouts.navigation-link class="grow" type="call-to-action" resource="contributions" action="publish"
            :action-args="$contribution" label="Publish"
            icon-path="M9.348 14.651a3.75 3.75 0 010-5.303m5.304 0a3.75 3.75 0 010 5.303m-7.425 2.122a6.75 6.75 0 010-9.546m9.546 0a6.75 6.75 0 010 9.546M5.106 18.894c-3.808-3.808-3.808-9.98 0-13.789m13.788 0c3.808 3.808 3.808 9.981 0 13.79M12 12h.008v.007H12V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
    @endif
    <x-layouts.navigation-link class="grow" type="call-to-action" resource="contributions.{{ $resource }}"
        action="destroy" :action-args="$model" label="Delete"
        icon-path="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />

</x-splade-modal>
