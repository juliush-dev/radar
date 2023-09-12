<div
    {{ $attributes->merge(['class' => 'w-full shadow-inner shadow-sm shadow-amber-800 rounded-md border-amber-300/60']) }}>
    <div class="flex gap-0 grow">
        <div class="flex p-3 gap-2 border-r border-amber-900">
            @foreach (explode(',', $skill->years_levels_covering_it) as $yearLevel)
                {{ $yearLevel }}
            @endforeach
        </div>
        <div class="p-3">
            {{ $skill->topic_group_covering_it }}
        </div>
    </div>
    <div class="p-3 text-xl font-medium border border-amber-900 border-x-0 rounded-ss-sm flex justify-between transition-shadow duration-200"
        v-bind:class="data.currentFocus == '{{ $skill->id }}' ? 'shadow shadow-yellow-200' : ''">
        <span>
            {{ $skill->contribution->title }}
        </span>
        <x-splade-button class="border-none outline-none"
            v-bind:class="data.currentFocus == '{{ $skill->id }}' ? 'shadow-yellow-200' : ''"
            @click="data.currentFocus == '{{ $skill->id }}' ? data.currentFocus = null :  data.currentFocus = '{{ $skill->id }}'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 transition-all duration-500"
                v-bind:class="data.currentFocus == '{{ $skill->id }}' ? 'rotate-180 text-yellow-200' : ''">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </x-splade-button>

        {{--  --}}
    </div>
    {{-- <div class="flex flex-col p-3 gap-2">
        @foreach (explode(',', $skill->fields_covered_by_it) as $field)
            <span>- {{ $field }}</span>
        @endforeach
    </div> --}}
    <x-splade-transition show="data.currentFocus == '{{ $skill->id }}'" animation="opacity"
        enter="transition-opacity duration-75" enter-from="opacity-0" enter-to="opacity-100"
        leave="transition-opacity duration-150" leave-from="opacity-100" leave-to="opacity-0" class="p-6">
        <h1>Cookie warning</h1>
    </x-splade-transition>

</div>
