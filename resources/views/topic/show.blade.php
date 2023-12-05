 <x-layouts.app :active-page="'Topic / ' . $topic->title"
     icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
     <main class="h-full overflow-y-auto dark:text-white text-slate-800 p-6 lg:px-80" @preserveScroll('topic')>
         <div class="mb-2">
             <div class="flex mb-4 items-center flex-wrap">
                 <h1 class="first-letter:uppercase text-xl dark:text-slate-100">
                     {{ $topic->title }}
                 </h1>
             </div>
             <div class="mb-4 grow flex gap-2 flex-wrap">
                 <x-nav-link modal href="{{ route('topics.index') . '?subject=' . $topic->subject->id }}"
                     class="dark:text-teal-300 text-teal-500">
                     {{ $topic->subject->title }}
                 </x-nav-link>
                 @if ($topic->years->count() > 0)
                     /<p class="font-light">
                         @foreach ($topic->years as $year)
                             <span class="first-letter:capitalize">{{ $year->year }}</span>
                             @if (!$loop->last)
                                 <span class="mx-2">-</span>
                             @endif
                         @endforeach
                     </p>
                 @endif
             </div>
             <div class="flex md:justify-end flex-wrap grow gap-6 items-center mt-4">
                 @can('use-dashboard')
                     <div class="flex justify-end items-center gap-6">
                         <x-splade-link :href="route('dashboard.index', ['tab' => 'topics'])"
                             class="w-fit flex items-center gap-2 justify-end text-fuchsia-500 hover:text-fuchsia-600 transition-all duration-300">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5 my-auto">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                             </svg>
                         </x-splade-link>
                         <x-splade-link :href="route('dashboard.index', ['tab' => 'notes'])"
                             class="w-fit flex items-center gap-2 justify-end text-fuchsia-500 hover:text-fuchsia-600 transition-all duration-300">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5 my-auto">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z" />
                             </svg>
                         </x-splade-link>
                     </div>
                 @endcan
                 @can('create-topic')
                     <Link href="{{ Auth::check() ? route('topics.create') : '#login-required' }}"
                         class="whitespace-nowrap text-fuchsia-400 hover:text-fuchsia-500">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                     </svg>
                     </Link>
                 @endcan
                 @auth
                     <section class="relative w-fit flex gap-6 text-white text-xs items-center">
                         @can('use-dashboard')
                             @if (!$topic->is_update)
                                 <x-splade-form submit-on-change :action="$topic->is_public
                                     ? route('topics.unpublish', $topic)
                                     : route('topics.publish', $topic)" method="post" :default="['is_public' => $topic->is_public]"
                                     class="text-fuchsia-400 hover:text-fuchsia-500">
                                     <x-splade-checkbox inline label="Public" name="is_public" value="1"
                                         class="checked:bg-fuchsia-400" />
                                 </x-splade-form>
                             @endif
                         @endcan
                         @if ($topic->is_update && $topic->potentialReplacement == null)
                             @can('use-dashboard')
                                 <x-splade-link method="post" :href="route('topics.apply-update', $topic)"
                                     class="text-teal-500 hover:text-teal-600 dark:text-teal-200 transition-all duration-300">
                                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                         <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                     </svg>
                                 </x-splade-link>
                             @endcan
                         @endif
                         @can('update-topic', $topic)
                             @if (!$topic->is_update || $topic->potentialReplacement == null)
                                 <x-layouts.navigation-link
                                     class="text-fuchsia-400 hover:text-fuchsia-500 transition-all duration-300"
                                     resource="topics" action="edit" :action-args="$topic">
                                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                         <path stroke-linecap="round" stroke-linejoin="round"
                                             d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                     </svg>
                                 </x-layouts.navigation-link>
                             @endif
                         @endcan
                         @can('delete-topic', $topic)
                             @if ($topic->potentialReplacement == null)
                                 <x-layouts.navigation-link class="text-red-500 hover:text-red-600 transition-all duration-300"
                                     resource="topics" action="destroy" :action-args="$topic">
                                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                         <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                     </svg>
                                 </x-layouts.navigation-link>
                             @endif
                         @endcan
                     </section>
                 @endauth
                 <x-volatile-sign :model="$topic" />
             </div>
         </div>
         <hr class="mb-8 border-slate-200 dark:border-slate-700">
         @can('see-topic-update-path', $topic)
             @if ($topic->is_update)
                 <section class="mb-8 border border-pink-800 p-4">
                     <h2 class="text-2xl mb-4">
                         Will replace
                     </h2>
                     <x-splade-link :href="route('topics.show', $topic->potentialReplacementOf)"
                         class="text-teal-600 hover:text-teal-700 dark:text-teal-400 transition-colors duration-300">
                         {{ $topic->potentialReplacementOf->title }}
                     </x-splade-link>
                 </section>
             @endif
             @if ($topic->potentialReplacement)
                 <section class="mb-8 border border-pink-800 p-4">
                     <h2 class="text-2xl mb-4">
                         Will be replaced by
                     </h2>
                     <x-splade-link :href="route('topics.show', $topic->potentialReplacement)"
                         class=" text-teal-600 hover:text-teal-700 dark:text-teal-400 transition-colors duration-300">
                         {{ $topic->potentialReplacement->title }}
                     </x-splade-link>
                 </section>
             @endif
         @endcan

         <div class="flex flex-col gap-4 w-full mb-8">
             <note-space v-slot="notes">
                 @auth
                     <h2 class="text-2xl mb-4">Own notes</h2>
                     @auth
                         @foreach ($topic->notes()->where('user_id', Auth::user()->id)->get() as $note)
                             <x-note :$note />
                         @endforeach
                     @endauth
                     <div class="w-full mb-8">
                         <x-splade-form action="{{ route('topics.notes.store', $topic) }}" method="post"
                             class="h-6 mx-auto">
                             <button type="submit" class="text-fuchsia-400 hover:text-fuchsia-500">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                 </svg>
                             </button>
                         </x-splade-form>
                     </div>
                     <h2 class="text-2xl mb-4">Others notes</h2>
                     @foreach ($topic->notes()->whereNot('user_id', Auth::user()->id)->where('is_public', true)->get() as $note)
                         <x-note :$note :editable="false" />
                     @endforeach
                 @else
                     <h2 class="text-2xl mb-4">Notes</h2>
                     @foreach ($topic->notes()->where('is_public', true)->get() as $note)
                         <x-note :$note :editable="false" />
                     @endforeach
                 @endauth
             </note-space>
         </div>

         <h2 class="text-2xl mb-4">In the same subject</h2>
         <div class="grid grid-cols-1 lg:grid-cols-2 w-full gap-6 mx-auto mb-8">
             @foreach ($topic->inTheSameSubject()->get() as $topic)
                 <x-topic :topic="$topic" />
             @endforeach
         </div>
         <hr class="mb-8 border-slate-200 dark:border-slate-700">
         <h2 class="text-2xl mb-4">Skills you gain learning this topic</h2>
         <div class="mb-8 columns-1 space-y-6 w-full">
             @foreach ($topic->skills as $topicSkill)
                 <x-skill :skill="$topicSkill->skill" :user-assessment="$rq->userSkillAssessment($topicSkill->skill)" />
             @endforeach
         </div>
         <h2 class="text-2xl mb-4 dark:text-slate-100">
             Fields
         </h2>
         <div class="mb-10 columns-1 space-y-6 w-full">
             @foreach ($topic->fields as $skillField)
                 <x-field :field="$skillField->field" />
             @endforeach
         </div>
         <div class="@if (Agent::isAndroidOs() || Agent::isEdge()) mb-36 @endif"></div>
     </main>
 </x-layouts.app>
