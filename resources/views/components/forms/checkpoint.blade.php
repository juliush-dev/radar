 <checkpoint v-slot="checkpoint" :form="form">
     <div class="sticky right-0 overflow-x-auto top-0 z-10 flex bg-white gap-0 w-full flex-wrap shadow mb-10">
         <div class="px-6 py-4 cursor-pointer w-fit bg-pink-500 text-white"
             @click.prevent="checkpoint.setActiveTab('flash cards')">
             Questons cubes
             <span v-text="checkpoint.form.knowledgeCubes.length"></span>
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
     <div class="bg-white border border-slate-200 dark:border-white">
         <div class="p-4">
             <div class="flex items-center gap-4 flex-nowrap mb-6 whitespace-nowrap">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                 </svg>
                 <h2 v-text="checkpoint.form.title" class="text-2xl font-medium first-letter:uppercase"></h2>
             </div>
             <x-splade-input name="title" label="What is this checkpoint about?" class="mb-6 first-letter:uppercase"
                 placeholder="Netzwerkkomponenten" />
             <x-splade-textarea rows="6" name="goal" label="What should one take out of this checkpoint?"
                 placeholder="Die verschiedene Netzwerkkomponenten kennen und deren Rollen im Netzwerk" />
         </div>
         <div v-for="(knowledgeCube, index) in checkpoint.form.knowledgeCubes">
             <x-forms.knowledge-cube />
         </div>
         <div v-if="form.title.length > 3" class="flex flex-col gap-4 p-4">
             <x-splade-button type="call-to-action" @click.prevent="checkpoint.addKnowledgeCube"
                 class="w-fit bg-amber-500 hover:bg-amber-600 text-white">
                 Add knowledge cube
             </x-splade-button>
         </div>
     </div>
 </checkpoint>
