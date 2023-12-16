 @php
     $referers = $note->relativeOf;
 @endphp
 <x-layouts.app :active-page="'Note / ' . $note->extractTitle()"
     icon="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
     <div class="max-h-[90%] w-full flex flex-nowrap gap-0 overflow-y-hidden mx-5">
         <section
             class="relative h-full overflow-y-auto @if (count($referers) < 1) ) min-w-[100%] @else min-w-[90%] @endif lg:border-r-4 border-slate-200 dark:border-slate-700">
             <div
                 class="p-3 lg:px-11 z-10 sticky top-0 text-2xl py-3 font-medium  mb-3 whitespace-nowrap bg-pink-400 dark:bg-fuchsia-800 dark:text-white dark:border-slate-700 shadow w-full">
                 <Link href="{{ route('notes.edit', $note) }}" class="text-xl text-slate-50 dark:text-slate-100">
                 {{ $note->extractTitle() }}</Link>
             </div>
             <div class="p-3 lg:px-11 max-w-full">
                 <div class="ProseMirror">{!! $note->content !!}</div>
             </div>
         </section>
         @foreach ($referers as $referer)
             <section
                 class="relative h-full overflow-y-auto  lg:border-r-4 border-slate-200 dark:border-slate-700 min-w-[100%] lg:min-w-[90%]">
                 <div
                     class="p-3 lg:px-11 z-10 sticky top-0 text-2xl py-3 font-medium  mb-3 whitespace-nowrap bg-blue-400 dark:bg-blue-800 dark:text-white dark:border-slate-700 shadow w-full">
                     {{-- <Link href="{{ route('topics.show', $referer->topic) }}"
                         class="text-base font-normal transition-colors duration-300 text-slate-50 hover:text-slate-100">
                     {{ $referer->topic->title }}
                     </Link><br> --}}
                     <Link href="{{ route('notes.edit', $referer) }}" class="text-xl text-slate-50 dark:text-slate-100">
                     {{ $referer->extractTitle() }}</Link>
                 </div>
                 <div class="p-3 lg:px-11 w-full">
                     <div class="ProseMirror">{!! $referer->content !!}</div>
                 </div>
             </section>
         @endforeach
     </div>
 </x-layouts.app>
