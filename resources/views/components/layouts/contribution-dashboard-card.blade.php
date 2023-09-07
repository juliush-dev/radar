<div class="p-4 flex flex-col gap-5 shadow rounded shadow-teal-800">
    <div class="flex gap-5 text-3xl font-medium capitalize items.center whitespace-nowrap">
        {{ $total }}
        {{ $label }}
    </div>
    <div class="flex flex-wrap gap-5 text-sm items.center">
        <div class="p-1 {{ $approved > 0 ? 'text-green-300' : 'text-white/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $approved }}</span>
            Approved
        </div>
        <div class="p-1 {{ $pending > 0 ? 'text-yellow-400' : 'text-white/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $pending }}</span>
            Pending
        </div>
        <div class="p-1 {{ $published > 0 ? 'text-teal-400' : 'text-white/60' }} rounded-md capitalize">
            <span class="font-medium">{{ $published }}</span>
            Published
        </div>
        <x-layouts.navigation-link open-as="slideover" :resource="'contribution.' . $type" action="create" :label="'create new ' . $type"
            icon-path="M12 6v12m6-6H6" />
    </div>
</div>
