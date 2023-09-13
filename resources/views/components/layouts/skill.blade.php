 <div v-if="data.focusedSkill == null || data.focusedSkill == '{{ $skill->id }}'">

     <div {{ $attributes->merge(['class' => 'transition-shadow duration-200 w-full relative']) }}
         v-bind:class="data.focusedSkill == '{{ $skill->id }}' ? 'sticky top-0' : 'hover:shadow-lg'">
         <div class="flex gap-0 grow text-slate-500 border border-slate-200">
             <div class="flex px-6 py-3 gap-4 border-r border-slate-200">
                 @foreach (explode(',', $skill->years_levels_covering_it) as $yearLevel)
                     <span>{{ $yearLevel }}</span>
                 @endforeach
             </div>
             <div class="px-6 py-3">
                 {{ $skill->topic_group_covering_it }}
             </div>
         </div>
         <div class="relative bg-slate-100 px-6 py-3 text-md font-medium border border-slate-300 rounded-ss-sm flex gap-2 transition-shadow duration-200 text-slate-500"
             v-bind:class="data.focusedSkill == '{{ $skill->id }}' ? 'bg-teal-500/10 text-slate-800' : ''"
             @click="data.focusedSkill == '{{ $skill->id }}' ? data.focusedSkill = data.addingNewTopic = data.addingNewLearningMaterial = null :  data.focusedSkill = '{{ $skill->id }}'">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                 <path stroke-linecap="round" stroke-linejoin="round"
                     d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                 <path stroke-linecap="round" stroke-linejoin="round"
                     d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
             </svg>

             <span>
                 {{ $skill->contribution->title }}
             </span>

             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6 transition-all duration-500 ml-auto"
                 v-bind:class="data.focusedSkill == '{{ $skill->id }}' ? 'rotate-180 text-teal-600' : ''">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
             </svg>
             <div class="absolute right-1/2 -top-3 flex gap-2 ml-auto">
                 <div class="rounded-sm border border-slate-300 flex gap-2 px-3 py-0.5 bg-slate-50 opacity-75">
                     <span class="text-sm">{{ $skill->requiredTopics->count() }}</span>
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="black" class="w-4 h-4 translate-y-0.5">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                     </svg>
                 </div>
                 <div class="rounded-sm border border-slate-300 flex gap-2 px-3 py-0.5 bg-slate-50 opacity-75">
                     <span class="text-sm">{{ $skill->requiredTopics->count() }}</span>
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="black" class="w-4 h-4 translate-y-0.5">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                     </svg>
                 </div>
                 {{-- <x-splade-transition show="data.focusedSkill == '{{ $skill->id }}'" animation="slide-right"
                     class="pl-6 pb-3 flex flex-col gap-6">
                     <x-splade-button>Wa</x-splade-button>
                 </x-splade-transition> --}}
             </div>
         </div>
         {{-- <div class="flex flex-col p-3 gap-2">
        @foreach (explode(',', $skill->fields_covered_by_it) as $field)
            <span>- {{ $field }}</span>
        @endforeach
    </div> --}}
         <x-splade-transition show="data.focusedSkill == '{{ $skill->id }}'" animation="slide-left"
             class="pl-6 pb-6 flex flex-col gap-6">
             @foreach ($skill->requiredTopics as $requiredTopic)
                 <x-layouts.topic :topic="$requiredTopic->topic" />
             @endforeach
             <h1 class="text-xl text-center">🙂 Want to add a new topic?</h1>
             <div class="flex gap-6 justify-end">
                 @php
                     $topicsOptions = $skill->topicsOptions();
                 @endphp
                 @if (count($topicsOptions) > 0)
                     <x-splade-form :action="route('topic.store', $skill)" class="flex flex-col gap-6 w-96">
                         <x-splade-select name="topic" placeholder="Select topic to add" option-label="title"
                             option-value="id" :options="$skill->topicsOptions()" />
                         <x-splade-submit>Add selected topic</x-splade-submit>
                     </x-splade-form>
                     <span class="shrink font-medium">Or</span>
                 @endif
                 <x-splade-form :action="route('topic.store', $skill)" class="flex flex-col gap-6  w-96">
                     <x-splade-input name="title" label="Topic" />
                     <x-splade-select name="years_teached_at" :options="$skill->topicsYearsOptions()" label="Year levels" />
                     <x-splade-select name="topic_field" :options="$skill->topicsFieldsOptions()" label="Field" />
                     <x-splade-select name="subject" label="subject" option-label="title" option-value="id"
                         :options="$skill->topicsSubjectsOptions()" />
                     <x-splade-submit>Create topic to add</x-splade-submit>
                 </x-splade-form>
             </div>
         </x-splade-transition>
     </div>
 </div>
