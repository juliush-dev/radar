 <x-layouts.app :active-page="'Note / ' . $note->extractTitle()"
     icon="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
     <div class="h-full w-full flex flex-col gap-0 justify-evenly overflow-hidden">
         <div
             class="h-1/2 overflow-auto bg-slate-50 dark:bg-slate-800 flex flex-nowrap gap-0 shadow-sm shadow-slate-400 w-full">
             @foreach ($note->categoryOf()->whereNot('topic_id', $note->topic->id)->get() as $referer)
                 <section
                     class="min-h-screen @if (!$loop->last) min-w-[80%] md:min-w-[70%] lg:min-w-[50%] border-r-4 border-slate-200 dark:border-slate-700 @else min-w-[80%] md:min-w-[50%] @endif">
                     <div
                         class="z-10 sticky top-0 text-2xl py-3 font-medium  mb-3 whitespace-nowrap px-6 bg-slate-100 dark:bg-slate-800 dark:text-white dark:border-slate-700 shadow w-full">
                         <Link href="{{ route('topics.show', $referer->topic) }}"
                             class="text-base font-normal transition-colors duration-300 text-fuchsia-400 hover:text-fuchsia-500">
                         {{ $referer->topic->title }}
                         </Link><br>
                         <span class="text-xl text-slate-400 dark:text-slate-500">{{ $referer->extractTitle() }}</span>
                     </div>
                     <div class="w-full pl-6 md:px-6 pb-6 min-h-full">
                         <div class="ProseMirror">{!! $referer->content !!}</div>
                     </div>
                 </section>
             @endforeach
         </div>
         <div
             class="h-1/2 overflow-auto bg-slate-50 dark:bg-slate-800 flex flex-nowrap gap-0 shadow-sm shadow-slate-400 w-full">
             <section
                 class="min-h-screen min-w-[80%] md:min-w-[70%] lg:min-w-[50%] border-r-4 border-slate-200 dark:border-slate-700">
                 <div
                     class="z-10 sticky top-0 text-2xl py-3 font-medium  mb-3 whitespace-nowrap px-6 bg-pink-400 dark:bg-pink-800 dark:text-white dark:border-slate-700 shadow w-full">
                     <Link href="{{ route('topics.show', $note->topic) }}"
                         class="text-base font-normal transition-colors duration-300 text-slate-50 hover:text-slate-100">
                     {{ $note->topic->title }}
                     </Link><br>
                     <span class="text-xl text-slate-50 dark:text-slate-100">{{ $note->extractTitle() }}</span>
                 </div>
                 <div class="w-full pl-6 md:px-6 pb-6 min-h-full">
                     <div class="ProseMirror">{!! $note->content !!}</div>
                 </div>
             </section>
             @foreach ($note->categoryOf()->where('topic_id', $note->topic->id)->get() as $referer)
                 <section
                     class="min-h-screen @if (!$loop->last) min-w-[80%] md:min-w-[70%] lg:min-w-[50%] border-r-4 border-slate-200 dark:border-slate-700 @else min-w-[80%] md:min-w-[50%] @endif">
                     <div
                         class="z-10 sticky top-0 text-2xl py-3 font-medium  mb-3 whitespace-nowrap px-6 bg-slate-100 dark:bg-slate-800 dark:text-white dark:border-slate-700 shadow min-w-full">
                         <Link href="{{ route('topics.show', $referer->topic) }}"
                             class="text-base font-normal transition-colors duration-300 text-fuchsia-400 hover:text-fuchsia-500">
                         {{ $referer->topic->title }}
                         </Link><br>
                         <span class="text-xl text-slate-400 dark:text-slate-500">{{ $referer->extractTitle() }}</span>
                     </div>
                     <div class="w-full pl-6 md:px-6 pb-6 min-h-full">
                         <div class="ProseMirror">{!! $referer->content !!}</div>
                     </div>
                 </section>
             @endforeach
         </div>
     </div>
 </x-layouts.app>
