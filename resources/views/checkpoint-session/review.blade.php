 @php
     $results = $session->userResults;
     $corrects = $rq->sessionCorrectsResults($session)->get();
     $wrongs = $rq->sessionWrongsResults($session)->get();
     $untouched = $rq->sessionUntouchedQuestions($session);
 @endphp
 <x-layouts.app :active-page="'Review/ ' . $session->checkpoint->title"
     icon="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5">
     <main class="h-full overflow-y-auto dark:text-white text-slate-600 p-6 lg:px-80" @preserveScroll('checkpoint')>
         <div class="flex mb-4 items-center flex-wrap">
             <h1 class="first-letter:uppercase text-xl dark:text-slate-100">
                 <x-nav-link href="{{ route('checkpoints.preview', $session->checkpoint) }}"
                     class="first-letter:uppercase text-violet-500 group-hover:text-violet-700 dark:text-violet-300 dark:group-hover:text-violet-400 hover:text-violet-500 transition-colors duration-300">
                     {{ $session->checkpoint->title }}
                 </x-nav-link>
             </h1>
             @can('use-dashboard')
                 <div class="flex justify-end items-center grow gap-6">
                     @if (!$session->checkpoint->is_update)
                         <x-splade-form submit-on-change :action="$session->checkpoint->is_public
                             ? route('checkpoints.unpublish', $session->checkpoint)
                             : route('checkpoints.publish', $session->checkpoint)" method="post" :default="['is_public' => $session->checkpoint->is_public]"
                             class="text-violet-400 hover:text-violet-500">
                             <x-splade-checkbox inline label="Public" name="is_public" value="1"
                                 class="checked:bg-fuchsia-400" />
                         </x-splade-form>
                     @endif
                     <x-splade-link :href="route('dashboard.index', ['tab' => 'checkpoints'])"
                         class="w-fit flex items-center gap-2 justify-end text-violet-500 hover:text-violet-600 transition-all duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                         </svg>
                     </x-splade-link>
                 </div>
             @endcan
         </div>
         <div class="text-sm flex items-center mb-4 gap-2 flex-wrap">
             <x-nav-link href="{{ route('topics.show', $session->checkpoint->topic) }}"
                 class="first-letter:uppercase text-violet-500 group-hover:text-violet-700 dark:text-violet-300 dark:group-hover:text-violet-400 hover:text-violet-500 transition-colors duration-300">
                 {{ $session->checkpoint->topic->title }}
             </x-nav-link>
             <div class="flex md:justify-end grow gap-6 items-center">
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
                 @if ($session->checkpoint->is_update || $session->checkpoint->potentialReplacement)
                     <span
                         class="px-2 bg-pink-600 w-fit font-mono text-sm text-white dark:text-slate-200  my-auto grow-0">Volatile
                         @if ($session->checkpoint->is_update)
                             <span
                                 class="px-2 bg-amber-300 font-mono text-slate-700 text-sm shadow shadow-amber-400">Update</span>
                         @endif
                     </span>
                 @endif
             </div>
         </div>
         <div
             class="text-md dark:text-slate-100 flex gap-6 justify-between rounded bg-white dark:bg-slate-700 shadow p-4">
             <p>Duration: {{ $session->countdown - $session->end_countdown }}s</p>
             <p>Touched {{ $session->userResults()->count() }} /
                 {{ $session->checkpoint->questionAnswerSets->count() }}</p>
             <p>Untouched: {{ $rq->sessionUntouchedQuestions($session)->count() }} </p>
             <p>Wrong: {{ $wrongs->count() }}</p>
             <p>Correct: {{ $corrects->count() }} </p>
         </div>
         <hr class="mb-8">
         <div class="dark:text-white">
             <checkpoint-session v-slot="checkpointSession">
                 <div class="mb-8">
                     <h2 class="text-2xl mb-4 dark:text-slate-100 flex flex-nowrap gap-2 items-center">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-8 h-8">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                         </svg>
                         <span>Questions you got wrong</span>
                     </h2>
                     @forelse ($wrongs as $quiz)
                         <div
                             class="text-white overflow-hidden shadow-md rounded border mb-10 p-8 bg-gradient-to-r from-red-400 to-red-500">
                             <p class="text-xl mb-2">{{ $quiz->title }}</p>
                             <hr class="mb-4 border-white">
                             <div>
                                 <p class="text-lg font-medium mb-2">
                                     @if ($quiz->is_cloze)
                                         {!! $quiz->question !!}
                                     @else
                                         {{ $quiz->question }}
                                     @endif
                                 </p>
                             </div>
                             <hr class="mb-4 border-white">
                             <div class="w-full overflow-hidden">
                                 @if ($quiz->is_cloze)
                                     <div class="text-lg mb-2"
                                         v-html="`{{ \App\View\Components\Checkpoint::wrapTokensInText($quiz->answer) }}`">
                                     </div>
                                 @else
                                     <p class="text-lg mb-2">
                                         {{ $quiz->answer }}
                                     </p>
                                 @endif
                                 {!! $quiz->answer_in_place_explanation !!}
                             </div>
                         </div>
                     @empty
                         <p>None</p>
                     @endforelse
                 </div>
                 <div class=" mb-8">
                     <h2 class="text-2xl mb-4 dark:text-slate-100  flex flex-nowrap gap-2 items-center">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-8 h-8">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                         </svg>
                         <span>
                             Questions you got right
                         </span>
                     </h2>
                     @forelse ($corrects as $quiz)
                         <div
                             class="text-white overflow-hidden shadow-md rounded border mb-10 p-8 bg-gradient-to-r from-green-400 to-green-500">
                             <p class="text-xl mb-2">{{ $quiz->title }}</p>
                             <hr class="mb-4 border-white">
                             <div>
                                 <p class="text-lg font-medium mb-2">
                                     @if ($quiz->is_cloze)
                                         {!! $quiz->question !!}
                                     @else
                                         {{ $quiz->question }}
                                     @endif
                                 </p>
                             </div>
                             <hr class="mb-4 border-white">
                             <div class="w-full overflow-hidden">
                                 @if ($quiz->is_cloze)
                                     <div class="text-lg mb-2"
                                         v-html="`{{ \App\View\Components\Checkpoint::wrapTokensInText($quiz->answer) }}`">
                                     </div>
                                 @else
                                     <p class="text-lg mb-2">
                                         {{ $quiz->answer }}
                                     </p>
                                 @endif
                                 {!! $quiz->answer_in_place_explanation !!}
                             </div>
                         </div>
                     @empty
                         <p>None</p>
                     @endforelse
                 </div>
                 <div class=" mb-8">
                     <h2 class="text-2xl mb-4 dark:text-slate-100 flex flex-nowrap gap-2 items-center">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-8 h-8">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                         </svg>
                         <span>
                             Questions you didn't touch
                         </span>
                     </h2>
                     @forelse ($untouched as $quiz)
                         <div
                             class="overflow-hidden shadow-md rounded border mb-10 p-8 bg-gradient-to-r from-slate-100 to-slate-300 text-slate-700">
                             <p class="text-xl mb-2">{{ $quiz->title }}</p>
                             <hr class="mb-4 border-white">
                             <div>
                                 <p class="text-lg font-medium mb-2">
                                     @if ($quiz->is_cloze)
                                         {!! $quiz->question !!}
                                     @else
                                         {{ $quiz->question }}
                                     @endif
                                 </p>
                             </div>
                             <hr class="mb-4 border-white">
                             <div class="w-full overflow-hidden">
                                 @if ($quiz->is_cloze)
                                     <div class="text-lg mb-2"
                                         v-html="`{{ \App\View\Components\Checkpoint::wrapTokensInText($quiz->answer) }}`">
                                     </div>
                                 @else
                                     <p class="text-lg mb-2">
                                         {{ $quiz->answer }}
                                     </p>
                                 @endif
                                 {!! $quiz->answer_in_place_explanation !!}
                             </div>
                         </div>
                     @empty
                         <p>None</p>
                     @endforelse
                 </div>
             </checkpoint-session>
         </div>
         <div class="flex gap-5 items-center justify-end">
             @can('delete-checkpoint-session', $session)
                 <x-splade-link method="delete" href="{{ route('sessions.destroy', $session) }}"
                     confirm="Deletion requested" confirm-text="This session will be permanently deleted?"
                     confirm-button="Yes, delete it!" cancel-button="No, keep it!"
                     class="text-red-500 hover:text-red-600 text-sm">
                     delete
                 </x-splade-link>
             @endcan
         </div>
     </main>
 </x-layouts.app>
