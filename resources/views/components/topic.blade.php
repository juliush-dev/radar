<x-splade-data :default="[
    'expanded' => $expanded,
]">
    <div {{ $attributes->merge(['class' => 'w-full relative transition duration-200']) }}
        v-bind:class="!data.expanded ? 'hover:shadow-lg' : ''">
        <div class="flex gap-0 grow text-slate-500 border border-slate-300">
            <div class="flex px-6 py-3 gap-2 border-r border-slate-300">
                {{ $topic->year_teached_at }}
            </div>
            <div class="px-6 py-3">
                {{ $topic->topic_field }}
            </div>
            <div class="flex px-6 py-3 gap-2 border-l border-slate-300">
                {{ $topic->subjectCoveringIt->subject->contribution->title }}
            </div>
            <div class="flex px-6 py-3 gap-2 border-l border-slate-300 justify-end ml-auto">
                @for ($i = 0; $i < 6; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 {{ $i < 4 ? 'text-orange-300' : '' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" fill="currentColor"
                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                @endfor
            </div>
        </div>
        @php
            $route = '';
            if ($expanded) {
                if ($skill != null) {
                    $route = route('skills.show', $skill);
                } else {
                    $route = route('topics.index');
                }
            } elseif ($skill != null) {
                $route = route(
                    'skill-topics.show',
                    \App\Models\SkillTopic::where('skill_id', $skill->id)
                        ->where('topic_id', $topic->id)
                        ->first(),
                );
            } else {
                $route = route('topics.show', $topic);
            }
        @endphp
        <x-splade-button type="link" :href="$route"
            class="relative w-full px-3 py-3 text-md font-medium border border-slate-300 rounded-ss-sm flex gap-2 transition-shadow duration-200 text-slate-500"
            v-bind:class="data.expanded ? 'bg-teal-500 text-white' :  'bg-slate-200'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>

            <span>
                {{ $topic->contribution->title }}
            </span>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 transition-all duration-500 ml-auto"
                v-bind:class="data.expanded && 'rotate-180'">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
            <div class="absolute right-1/2 -top-3 flex gap-2 ml-auto text-black">
                <div class="rounded-sm border border-slate-300 flex gap-2 px-3 py-0.5 bg-slate-50 opacity-75">
                    <span class="text-sm">{{ $topic->learningMaterials->count() }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="black" class="w-4 h-4 translate-y-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
            </div>
        </x-splade-button>

        <x-splade-transition show="data.expanded" animation="slide-left" enter="transition-opacity duration-200"
            leave="transition-opacity duration-200" class="px-6 py-3">
            dsds
        </x-splade-transition>

    </div>
</x-splade-data>
