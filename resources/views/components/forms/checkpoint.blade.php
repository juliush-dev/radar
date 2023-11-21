 <checkpoint v-slot="checkpoint" :form="form">
     <div class="sticky right-0 overflow-x-auto top-0 z-10 flex bg-white gap-0 w-full flex-wrap shadow mb-10">
         <div class="px-6 py-4 cursor-pointer w-fit bg-pink-500 text-white">
             Checkpoint
         </div>
         <div class="flex justify-start md:ml-auto w-full md:w-fit">
             <x-splade-submit
                 class="bg-fuchsia-500 h-full w-full md:w-32 hover:bg-fuchsia-600 shadow-md whitespace-nowrap"
                 label=" {{ Route::currentRouteName() == 'checkpoints.edit' ? 'Update' : 'Create' }}" />
             <Link href="{{ Referer::get() }}"
                 class=" whitespace-nowrap flex items-center justify-center w-full md:w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
             Cancel
             </Link>
         </div>
     </div>
     <div
         class="p-6 border rounded-md shadow bg-white mb-6 dark:bg-slate-800 text-slate-500 dark:text-slate-400 dark:border-slate-400">
         <div class="flex items-center gap-4 flex-nowrap mb-6 whitespace-nowrap">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                 <path stroke-linecap="round" stroke-linejoin="round"
                     d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
             </svg>
             <h2 class="text-2xl font-medium first-letter:uppercase">{{ $topic->title }}</h2>
         </div>
         <p>
             A Checkpoint is a source of exercises about a particular concept in a topic
         </p>
     </div>
     <div class="bg-white border border-slate-200 dark:border-white">
         <div class="p-4">
             <x-splade-input name="title" label="Title" class="mb-6 first-letter:uppercase"
                 placeholder="Netzwerkkomponenten" />
             <x-splade-input name="source" label="Source"
                 placeholder="https://moodle-hnbk.de/.../SD_U_LF05_WOR_TheorieSkript_%C3%9Cbungen_2023-06-20.pdf"
                 class="mb-6" />
         </div>
     </div>
 </checkpoint>
