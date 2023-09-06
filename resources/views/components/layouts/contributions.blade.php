<div class="relative flex flex-col gap-8 h-full bg-slate-900/60 p-8 rounded-md shadow-2xl">
    <div class="flex flex-col gap-8 h-full">
        <h1 class="text-3xl mb-5 flex gap-2 items.center capitalize">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
            </svg>
            Contributed {{ $label }}
        </h1>
        <div class="absolute bottom-0 right-0 p-8">
            <x-layouts.navigation-link :resource="'contribution.' . $type" :label="$actionLabel" open-as="slideover" action="create"
                type="call-to-action"
                iconPath="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
        </div>
        <x-splade-table :for="$tableClass" pagination-scroll="head">
            <x-slot name="body">
                @foreach (app($tableClass)->for() as $r)
                    <tr>
                        <td class="p-6">{{ $r->contribution->title }}</td>
                        <td class="p-6">{{ $r->knowledge_group_covering_it }}</td>
                        <td class="p-6">{{ $r->years_levels_covering_it }}</td>
                        <td class="p-6">{{ $r->fields_covered_by_it }}</td>
                        <td class="p-6">
                            {{ $r->contribution->modificationRequests()->latest()->first()->modification_request_state }}
                        </td>
                        <td class="p-6">{{ $r->created_at }}</td>
                    </tr>
                @endforeach
            </x-slot>
        </x-splade-table>
    </div>
</div>
