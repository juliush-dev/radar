<div {{ $attributes->merge(['class' => 'w-full']) }}>
    <div class="flex gap-0 grow">
        <div class="flex p-3 gap-2 border-r border-teal-900">
            @foreach (explode(',', $skill->years_levels_covering_it) as $yearLevel)
                {{ $yearLevel }}
            @endforeach
        </div>
        <div class="p-3">
            {{ $skill->topic_group_covering_it }}
        </div>
    </div>
    <div class="p-3 text-xl font-medium border border-teal-900 border-x-0">
        {{ $skill->contribution->title }}
    </div>
    <div class="flex flex-col p-3 gap-2">
        @foreach (explode(',', $skill->fields_covered_by_it) as $field)
            <span>- {{ $field }}</span>
        @endforeach
    </div>
</div>
