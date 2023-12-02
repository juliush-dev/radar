 <x-layouts.app active-page="Topics"
     icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
     <div class="h-full flex flex-col overflow-y-auto pb-20 md:pb-8 @if (Agent::isAndroidOs() && Agent::isEdge()) pb-36 @endif"
         @preserveScroll('topics')>
         <x-topics-filter :years="$rq->years()" :subjects="$rq->subjects()" :fields="$rq->fields()" :skills="$rq->skills()" />
         <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 px-6 lg:px-10 w-full">
             @foreach ($topics as $topic)
                 <x-topic :topic="$topic" />
             @endforeach
             @if ($filterIsSet && $topics->count() == 0)
                 <p class="text-xl mb-4 dark:text-white">No topic matches the filter</p>
             @endif
         </div>
     </div>
 </x-layouts.app>
