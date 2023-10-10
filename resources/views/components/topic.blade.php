 <div
     class="group break-inside-avoid w-full border border-violet-300 text-white shadow shadow-violet-400/80 dark:shadow-violet-400/50 hover:shadow-md hover:shadow-violet-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
     <x-nav-link href="{{ route('topics.show', $topic) }}"
         class="text-lg first-letter:uppercase w-full text-violet-500 group-hover:text-violet-700 dark:text-violet-300 dark:group-hover:text-violet-400 hover:text-violet-500 transition-colors duration-300">
         <h1 class="mb-2">{{ $topic->title }}</h1>
     </x-nav-link>

     <p class="font-normal text-sm mb-2 text-slate-500 dark:text-slate-300">
         @can('update-subject')
             <x-nav-link modal href="{{ route('topics.subjects.edit', $topic->subject) }}"
                 class="dark:text-teal-300 text-teal-500">
                 {{ $topic->subject->title }}
             </x-nav-link>/
         @else
             <span class="dark:text-slate-300 text-slate-600">
                 {{ $topic->subject->title }}
             </span>/
         @endcan
         @foreach ($topic->years as $year)
             <span
                 class="first-letter:capitalize whitespace-nowrap dark:text-slate-300 text-slate-500">{{ $year->year }}</span>
             @if (!$loop->last)
                 <span class="mx-1">-</span>
             @endif
         @endforeach
         <span class="mx-1">/</span>
         @php
             $volatileTopicLearningMaterials = \App\Models\LearningMaterial::where('topic_id', $topic->id)
                 ->where('is_public', false)
                 ->get();
         @endphp
         <span class="dark:text-slate-300 text-slate-500 flex gap-2 flex-nowrap">
             {{ $topic->learningMaterials->count() }}
             @if ($volatileTopicLearningMaterials->count() > 0)
                 <span class="px-2 bg-pink-500 text-white text-xs my-auto">
                     % {{ $volatileTopicLearningMaterials->count() }}
                 </span>
             @endif
             Lms
         </span>
     </p>
     <div class="w-full flex justify-between text-white text-xs items-center">
         @auth
             <div class="flex gap-4 items-center">
                 @can('use-dashboard')
                     @if (!$topic->is_update)
                         <x-splade-form submit-on-change :action="$topic->is_public
                             ? route('topics.unpublish', $topic)
                             : route('topics.publish', $topic)" method="post" :default="['is_public' => $topic->is_public]"
                             class="text-violet-400 hover:text-violet-500">
                             <x-splade-checkbox inline label="Public" name="is_public" value="1"
                                 class="checked:bg-fuchsia-400" />
                         </x-splade-form>
                     @endif
                 @endcan
                 @if ($topic->is_update && $topic->topicUpdating == null)
                     @can('use-dashboard')
                         <x-splade-link method="post" :href="route('topics.apply-update', $topic)"
                             class="text-teal-500 hover:text-teal-600 dark:text-teal-200">
                             Apply update
                         </x-splade-link>
                     @endcan
                 @endif
                 @can('update-topic', $topic)
                     @if (!$topic->is_update || $topic->topicUpdating == null)
                         <x-layouts.navigation-link class="text-blue-400" label="edit" resource="topics" action="edit"
                             :action-args="$topic" />
                     @endif
                 @endcan
                 @can('delete-topic', $topic)
                     <x-layouts.navigation-link class="text-red-400" label="delete" resource="topics" action="destroy"
                         :action-args="$topic" />
                 @endcan
             </div>
         @endauth
         @if ($topic->is_update || $topic->topicUpdating)
             <span
                 class="whitespace-nowrap px-2 bg-pink-600 w-fit mb-2 font-mono text-sm dark:text-slate-200 my-auto grow-0">Volatile
                 @if ($topic->is_update)
                     <span
                         class="px-2 bg-amber-300 font-mono text-slate-700 text-sm shadow shadow-amber-400">Update</span>
                 @endif
             </span>
         @endif
     </div>
 </div>
