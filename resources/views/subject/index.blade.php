<x-layouts.app>
    <x-layouts.contributions label="Skills Board" type="skill" actionLabel="Submit a new skill">
        <x-splade-table :for="$publicSkills" pagination-scroll="head">
            <x-slot:empty-state>
                <p class="p-6">Nothing for the moment. You can login and submit somthing to be added hier!</p>
            </x-slot>
            @if ($component->for->resource->count() > 0)
                <x-slot:body>
                    @foreach ($component->for->resource as $r)
                        <tr>
                            <td class="pl-6 py-2 text-slate-300">{{ $r->contribution->title }}</td>
                        </tr>
                    @endforeach
                </x-slot>
            @endif
        </x-splade-table>
    </x-layouts.contributions>
</x-layouts.app>
