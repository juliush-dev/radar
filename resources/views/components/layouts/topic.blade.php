<div {{ $attributes->merge(['class' => 'w-full border rounded-md border-amber-900']) }}>
    <div class="flex gap-0 grow">
        <div class="flex p-3 gap-2 border-r border-amber-900">
            @foreach (explode(',', $topic->years_teached_at) as $yearLevel)
                {{ $yearLevel }}
            @endforeach
        </div>
        <div class="p-3">
            {{ $topic->topic_field }}
        </div>
        <div class="p-3 border-l border-amber-900">
            {{ $topic->subjectCoveringIt->subject->contribution->title }}
        </div>
    </div>
    <div class="p-3 text-xl font-medium border border-amber-900 border-x-0">
        {{ $topic->contribution->title }}
    </div>
    <div class="p-3 border-b border-amber-900 flex gap-2 itemce.center">
        <span>Proficiency: </span>
        <div class="flex gap-1 items.center">
            @for ($i = 0; $i < 6; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 {{ $i < 4 ? 'text-amber-300' : '' }}">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                </svg>
            @endfor
        </div>
    </div>
</div>
