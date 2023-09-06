<x-layouts.app>
    <x-layouts.contributions type="skill" label="skills" action-label="New skill" :table="$contributedSkills">
        <x-slot:empty-state>
            <p>Whoops!</p>
        </x-slot>
        <x-slot name="body">
            @foreach ($contributedSkills as $r)
                <tr>
                    <td class="p-6">{{ $r->contribution->title }}</td>
                    <td class="p-6">{{ $r->topic_group_covering_it }}</td>
                    <td class="p-6">{{ $r->years_levels_covering_it }}</td>
                    <td class="p-6">{{ $r->fields_covered_by_it }}</td>
                    <td class="p-6">
                        {{ $r->contribution->modificationRequests()->latest()->first()->modification_request_state }}
                    </td>
                    <td class="p-6">{{ $r->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-layouts.contributions>
</x-layouts.app>
