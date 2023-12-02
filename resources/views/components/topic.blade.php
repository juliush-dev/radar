 <div
     class="group rounded-md border-2 w-full border-fuchsia-300 text-white shadow shadow-fuchsia-400/80 dark:shadow-fuchsia-400/50 hover:shadow-md hover:shadow-fuchsia-400/60  flex flex-col gap-0 p-6 transition-all duration-300">
     <x-nav-link href="{{ route('topics.show', $topic) }}"
         class="text-lg first-letter:uppercase w-full text-fuchsia-500 group-hover:text-fuchsia-700 dark:text-fuchsia-300 dark:group-hover:text-fuchsia-400 hover:text-fuchsia-500 transition-colors duration-300">
         <h1 class="mb-2">{{ $topic->title }}</h1>
     </x-nav-link>

     <div class="font-normal text-sm mb-2 text-slate-500 dark:text-slate-300 flex flex-wrap">
         @can('update-subject')
             <x-nav-link modal href="{{ route('topics.subjects.edit', $topic->subject) }}"
                 class="dark:text-teal-300 text-teal-500">
                 {{ $topic->subject->title }}
             </x-nav-link> &nbsp;/&nbsp;
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
             @if ($loop->last)
                 <span class="mx-1">/</span>
             @endif
         @endforeach
         <span class="dark:text-slate-300 text-slate-500 flex gap-2 flex-nowrap">
             {{ $topic->notes()->count() }}
             @if (($volatiles = $topic->volatileNotes()->count()) > 0)
                 <span class="px-2 bg-pink-500 text-white text-xs my-auto">
                     % {{ $volatiles }}
                 </span>
             @endif
             Notes
         </span>
     </div>
     <div class="w-full flex justify-between text-white text-xs items-center mt-auto">
         @auth
             <div class="flex gap-6 items-center">
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
                             class="text-teal-500 hover:text-teal-600 dark:text-teal-200">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-6 h-6 text-teal-500 hover:text-teal-600 shadow
                                    hover:shadow-md transition-all duration-300">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                             </svg>
                         </x-splade-link>
                     @endcan
                 @endif
                 @can('update-topic', $topic)
                     @if (!$topic->is_update || $topic->potentialReplacement == null)
                         <x-layouts.navigation-link class="text-fuchsia-400 hover:text-fuchsia-500transition-all duration-300"
                             resource="topics" action="edit" :action-args="$topic">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                             </svg>
                         </x-layouts.navigation-link>
                     @endif
                 @endcan
                 @can('delete-topic', $topic)
                     <x-layouts.navigation-link class="text-red-500 hover:text-red-600 transition-all duration-300"
                         resource="topics" action="destroy" :action-args="$topic">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                         </svg>
                     </x-layouts.navigation-link>
                 @endcan
             </div>
         @endauth
         <x-volatile-sign :model="$topic" />
     </div>
 </div>
