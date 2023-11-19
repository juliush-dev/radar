 @php
     $corrects = $session->correctResults();
     $wrongs = $session->wrongResults();
     $untouched = $session->untouchedKnowledge();
     $reviewGroupedByCubes = $wrongs
         ->concat($corrects)
         ->concat($untouched)
         ->groupBy('knowledge_cube_id');
 @endphp
 <x-layouts.app :active-page="'Review/ ' . $session->checkpoint->title"
     icon="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5">
     <div class="h-full overflow-y-auto dark:text-white text-slate-600" @preserveScroll('checkpoint')>
         <main class="p-6 lg:px-80">
             <h1 class="mb-4 first-letter:uppercase text-xl dark:text-slate-100">
                 <x-nav-link href="{{ route('checkpoints.preview', $session->checkpoint) }}"
                     class="first-letter:uppercase text-violet-500 group-hover:text-violet-700 dark:text-violet-300 dark:group-hover:text-violet-400 hover:text-violet-500 transition-colors duration-300">
                     {{ $session->checkpoint->title }}
                 </x-nav-link>
             </h1>
             <div class="text-sm flex flex-col mb-4 gap-2 flex-wrap">
                 <x-nav-link href="{{ route('topics.show', $session->checkpoint->topic) }}"
                     class="first-letter:uppercase text-violet-500 group-hover:text-violet-700 dark:text-violet-300 dark:group-hover:text-violet-400 hover:text-violet-500 transition-colors duration-300">
                     {{ $session->checkpoint->topic->title }}
                 </x-nav-link>
                 <div class="flex md:justify-end grow gap-6 items-center">
                     @can('use-dashboard')
                         <div class="flex justify-end items-center grow gap-6">
                             <x-splade-link :href="route('dashboard.index', ['tab' => 'checkpoints'])"
                                 class="w-fit flex items-center gap-2 justify-end text-violet-500 hover:text-violet-600 transition-all duration-300">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                 </svg>
                             </x-splade-link>
                             @if (!$session->checkpoint->is_update)
                                 <x-splade-form submit-on-change :action="$session->checkpoint->is_public
                                     ? route('checkpoints.unpublish', $session->checkpoint)
                                     : route('checkpoints.publish', $session->checkpoint)" method="post" :default="['is_public' => $session->checkpoint->is_public]"
                                     class="text-violet-400 hover:text-violet-500">
                                     <x-splade-checkbox inline label="Public" name="is_public" value="1"
                                         class="checked:bg-fuchsia-400" />
                                 </x-splade-form>
                             @endif
                         </div>
                     @endcan
                     @can('create-checkpoint')
                         <Link
                             href="{{ Auth::check() ? route('checkpoints.create', $session->checkpoint->topic) : '#login-required' }}"
                             class="whitespace-nowrap text-fuchsia-400 hover:text-fuchsia-500">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                         </svg>
                         </Link>
                     @endcan
                     @can('delete-checkpoint-session', $session)
                         @if ($session->potentialReplacement == null && !$session->checkpoint->topic->is_update)
                             <x-splade-link method="delete" href="{{ route('sessions.destroy', $session) }}"
                                 confirm="Deletion requested" confirm-text="This session will be permanently deleted?"
                                 confirm-button="Yes, delete it!" cancel-button="No, keep it!">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor"
                                     class="w-6 h-6 text-red-400 hover:text-red-500
                            transition-all duration-300">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                 </svg>
                             </x-splade-link>
                         @endif
                     @endcan
                 </div>
             </div>
             <div
                 class="text-md dark:text-slate-100 flex flex-wrap gap-6 justify-between rounded bg-white dark:bg-slate-700 shadow p-4">
                 <p>Duration: {{ $session->countdown - $session->end_countdown }}s</p>
                 <p>Touched {{ $corrects->count() + $wrongs->count() }} /
                     {{ $session->checkpoint->knowledge()->count() }}</p>
                 <p>Untouched: {{ $untouched->count() }} </p>
                 <p>Wrong: {{ $wrongs->count() }}</p>
                 <p>Correct: {{ $corrects->count() }} </p>
             </div>
             <hr class="mb-8">
         </main>
         <x-layouts.knowledge-cubes>
             @foreach ($reviewGroupedByCubes as $knowledgeCubeId => $reviewKnowledge)
                 @php($knowledgeCube = \App\Models\KnowledgeCube::find($knowledgeCubeId))
                 <x-checkpoint.knowledge-cube :$knowledgeCube :$reviewKnowledge context="review" />
             @endforeach
         </x-layouts.knowledge-cubes>
     </div>
 </x-layouts.app>
