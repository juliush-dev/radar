 <x-layouts.app active-page="Topics"
     icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
     <div class="h-full flex flex-col overflow-y-auto pb-8">
         <x-topics-filter :years="$rq->years()" :subjects="$rq->subjects()" :fields="$rq->fields()" :skills="$rq->skills()" />
         <div class="space-y-4 columns-1 lg:columns-2 xl:columns-3  w-full mb-4 gap-4 px-6 lg:px-10">
             @foreach ($topics as $topic)
                 <x-topic :topic="$topic" />
             @endforeach
             @if ($filterIsSet && $topics->count() == 0)
                 <p class="text-xl mb-4 dark:text-white">No topic matches the filter</p>
             @endif
         </div>
         @can('create-topic')
             <div class="px-6 lg:px-10">
                 <Link href="{{ Auth::check() ? route('topics.create') : '#login-required' }}"
                     class="text-fuchsia-400 hover:text-fuchsia-500">
                 Add new topic
                 </Link>
             </div>
         @endcan
     </div>
 </x-layouts.app>
