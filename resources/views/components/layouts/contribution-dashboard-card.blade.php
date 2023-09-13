<div class="p-4 flex flex-col gap-3 shadow border rounded">
    <div class="flex gap-5 text-xl font-semibold capitalize items.center whitespace-nowrap">
        {{ $total }}
        {{ $label }}
    </div>
    <div class="flex flex-wrap gap-5 text-sm items.center">
        <div class="p-1 {{ $approved > 0 ? 'text-teal-600' : 'text-slate-800/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $approved }}</span>
            Approved
        </div>
        <div class="p-1 {{ $pending > 0 ? 'text-yellow-400' : 'text-slate-800/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $pending }}</span>
            Pending
        </div>
        <div class="p-1 {{ $published > 0 ? 'text-teal-600' : 'text-slate-800/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $published }}</span>
            Published
        </div>
        <x-layouts.navigation-link open-as="slideover" :resource="'contribution.' . $type" action="create" :label="'create new ' . $type"
            icon-path="M12 6v12m6-6H6" />
    </div>
</div>
