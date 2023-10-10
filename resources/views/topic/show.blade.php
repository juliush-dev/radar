 <x-layouts.app :active-page="$topic->title"
     icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
     <main class="h-full overflow-y-auto dark:text-white text-slate-800 p-6 lg:px-80">
         <div class="flex  mb-4 items-center">
             <h1 class="first-letter:uppercase text-xl dark:text-slate-100">
                 {{ $topic->title }}
             </h1>
             @can('use-dashboard')
                 <div class="flex justify-end items-center grow gap-6">
                     @if (!$topic->is_update)
                         <x-splade-form submit-on-change :action="$topic->is_public
                             ? route('topics.unpublish', $topic)
                             : route('topics.publish', $topic)" method="post" :default="['is_public' => $topic->is_public]"
                             class="text-violet-400 hover:text-violet-500">
                             <x-splade-checkbox inline label="Public" name="is_public" value="1"
                                 class="checked:bg-fuchsia-400" />
                         </x-splade-form>
                     @endif
                     <x-splade-link :href="route('dashboard.index', ['tab' => 'topics'])"
                         class="w-fit flex items-center gap-2 justify-end text-violet-400 hover:text-violet-500 transition-all duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5 my-auto">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                         </svg> Topics dashboard
                     </x-splade-link>
                     <x-splade-link :href="route('dashboard.index', ['tab' => 'learning-materials'])"
                         class="w-fit flex items-center gap-2 justify-end text-violet-400 hover:text-violet-500 transition-all duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5 my-auto">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z" />
                         </svg> Lms dashboard
                     </x-splade-link>
                 </div>
             @endcan
         </div>
         <div class="text-sm flex items-center mb-4 gap-2 flex-wrap">
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
             @if ($topic->years->count() > 0)
                 <p class="font-light">
                     @foreach ($topic->years as $year)
                         <span class="first-letter:capitalize">{{ $year->year }}</span>
                         @if (!$loop->last)
                             <span class="mx-2">-</span>
                         @endif
                     @endforeach
                 </p>
             @endif
             <div class="flex md:justify-end grow gap-6 items-center">
                 @auth
                     @can('assess-topic')
                         @php
                             $topicAssessment = $topic
                                 ->assessments()
                                 ->where('user_id', auth()->user()->id)
                                 ->where('topic_id', $topic->id)
                                 ->first();
                         @endphp
                         <x-splade-form :action="route('topics.assess', $topic)" :default="['assessment' => $topicAssessment?->assessment]" submit-on-change class="flex flex-nowrap gap-1">
                             @for ($i = 1; $i <= 5; $i++)
                                 <svg @click="form.assessment = form.assessment == {{ $i }} ? ({{ $i - 1 }} < 1 ? 0 : {{ $i - 1 }} ) : {{ $i }}"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-5 h-5 text-yellow-400 hover:fill-yellow-400"
                                     v-bind:class="form.assessment && {{ $i }} <= form.assessment && 'fill-yellow-400'">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                 </svg>
                             @endfor
                         </x-splade-form>
                     @endcan
                 @else
                     <Link href="#login-required" class="flex flex-nowrap gap-1">
                     @for ($i = 1; $i <= 5; $i++)
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5  text-yellow-400">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                         </svg>
                     @endfor
                     </Link>
                 @endauth
                 @can('create-topic')
                     <Link href="{{ Auth::check() ? route('topics.create') : '#login-required' }}"
                         class="whitespace-nowrap text-fuchsia-400 hover:text-fuchsia-500">
                     Add new topic
                     </Link>
                 @endcan
                 @if ($topic->is_update || $topic->topicUpdating)
                     <span
                         class="px-2 bg-pink-600 w-fit font-mono text-sm text-white dark:text-slate-200  my-auto grow-0">Volatile
                         @if ($topic->is_update)
                             <span
                                 class="px-2 bg-amber-300 font-mono text-slate-700 text-sm shadow shadow-amber-400">Update</span>
                         @endif
                     </span>
                 @endif
             </div>
         </div>
         <hr class="mb-8">
         @can('see-topic-update-path', $topic)
             @if ($topic->is_update)
                 <section class="mb-8 border border-pink-800 p-4">
                     <h2 class="text-2xl mb-4">
                         Will replace
                     </h2>
                     <x-splade-link :href="route('topics.show', $topic->topicToUpdate)"
                         class="text-teal-600 hover:text-teal-700 dark:text-teal-400 transition-colors duration-300">
                         {{ $topic->topicToUpdate->title }}
                     </x-splade-link>
                 </section>
             @endif
             @if ($topic->topicUpdating)
                 <section class="mb-8 border border-pink-800 p-4">
                     <h2 class="text-2xl mb-4">
                         Will be replaced by
                     </h2>
                     <x-splade-link :href="route('topics.show', $topic->topicUpdating)"
                         class=" text-teal-600 hover:text-teal-700 dark:text-teal-400 transition-colors duration-300">
                         {{ $topic->topicUpdating->title }}
                     </x-splade-link>
                 </section>
             @endif
         @endcan
         @php
             $topicLearningMaterials = \App\Models\LearningMaterial::where('topic_id', $topic->id)
                 ->where(function ($query) {
                     $query->where('is_public', true)->orWhere('user_id', request()->user()?->id);
                 })
                 ->get();
             $volatileTopicLearningMaterials = \App\Models\LearningMaterial::where('topic_id', $topic->id)
                 ->where('is_public', false)
                 ->get();
         @endphp
         <h2 class="text-2xl mb-6 flex flex-nowrap gap-2 items-center">
             {{ $topic->learningMaterials->count() }}
             @if ($volatileTopicLearningMaterials->count() > 0)
                 <span class="px-2 bg-pink-500 text-white text-xs my-auto">
                     % {{ $volatileTopicLearningMaterials->count() }}
                 </span>
             @endif
             Learning Materials
         </h2>
         <div class="columns-1 lg:columns-2  xl:columns-3 space-y-4 gap-4 w-full mb-8">
             @foreach ($topicLearningMaterials as $lm)
                 @if (Illuminate\Support\Facades\Storage::disk('public')->exists($lm->alternative))
                     <x-splade-form method="get" :action="route('topics.learning-materials.download', $lm->id)" blob
                         class="break-inside-avoid group flex flex-col justify-center items-center relative w-full border border-slate-300">
                         @if (!$lm->is_public)
                             <span
                                 class="self-start px-2 bg-pink-600 w-fit font-mono text-sm text-white dark:text-slate-200  my-auto grow-0">Volatile
                             </span>
                         @endif
                         @if (in_array($lm->mime_type, array_column(\App\Enums\ImageMimeType::cases(), 'value')))
                             <img src="{{ Illuminate\Support\Facades\Storage::url($lm->path) }}" alt=""
                                 srcset="" class="w-full" height="auto">
                         @endif
                         <button type="submit"
                             class="flex gap-2 justify-center text-white text-sm bg-indigo-500 hover:bg-indigo-600 transition-all duration-200 w-full py-1 px-2">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-4 h-4 my-auto">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                             </svg>
                             <span class="first-letter:uppercase whitespace-nowrap">{{ $lm->title }}</span>
                         </button>
                         @can('delete-learning-material', $lm)
                             <x-splade-form method="delete" :action="route('topics.learning-materials.remove', $lm->id) . '?stay=1'" class="absolute bottom-0 right-0">
                                 <button type="submit"
                                     class="flex gap-2 text-white text-sm p-2 bg-red-600 rounded-t-none opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                         <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                     </svg>
                                 </button>
                             </x-splade-form>
                         @endcan
                     </x-splade-form>
                 @endif
             @endforeach
         </div>
         <x-splade-form :action="route('topics.learning-materials.upload', $topic->id) . '?stay=1'" class="mb-10">
             <x-splade-file label="Click the input field to add more" filepond preview name="newLearningMaterials[]"
                 class="text-lg font-light mb-2 text-left" multiple />
             @auth
                 <x-splade-submit class="bg-fuchsia-500" label="Share" />
             @else
                 <x-layouts.navigation-link class="px-6 flex justify-center text-white bg-fuchsia-500"
                     @click.prevent="" resource="#login-required" label="Share" />
             @endauth
         </x-splade-form>
         <h2 class="text-2xl mb-8">Skills</h2>
         <div class="mb-5 columns-1 space-y-6 w-full">
             @foreach ($topic->skills as $topicSkill)
                 <x-skill :skill="$topicSkill->skill" />
             @endforeach
         </div>
         @auth
             <section class="relative w-full flex gap-4 text-white text-xs items-center">
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
                 @if ($topic->is_update || $topic->topicUpdating)
                     <span
                         class="ml-auto px-2 bg-pink-600 w-fit mb-2 font-mono text-sm dark:text-slate-200 my-auto grow-0">Volatile
                         @if ($topic->is_update)
                             <span
                                 class="px-2 bg-amber-300 font-mono text-slate-700 text-sm shadow shadow-amber-400">Update</span>
                         @endif
                     </span>
                 @endif
             </section>
         @endauth
     </main>
 </x-layouts.app>
