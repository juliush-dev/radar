<div class="p-4 flex flex-col gap-3 shadow border rounded grow">
    <div class="flex gap-5 text-md font-medium capitalize items.center whitespace-nowrap">
        {{ $total }}
        {{ $label }}
    </div>
    <div class="flex flex-col flex-wrap gap-2 text-sm items.center">
        <div class="{{ $approved > 0 ? 'text-teal-600' : 'text-slate-800/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $approved }}</span>
            Approved
        </div>
        <div class="{{ $pending > 0 ? 'text-yellow-400' : 'text-slate-800/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $pending }}</span>
            Pending
        </div>
        <div class="{{ $published > 0 ? 'text-teal-600' : 'text-slate-800/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $published }}</span>
            Published
        </div>
        @if (!$hideAction)
            <x-layouts.navigation-link :$openAs type="call-to-action" :resource="'contributions.' . $type" action="create"
                :label="'create new ' . $type" />
        @endif
    </div>
</div>
