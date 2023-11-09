 <checkpoint v-slot="checkpoint" :form="form">
     <div class="sticky right-0 overflow-x-auto top-0 z-10 flex bg-white gap-0 w-full flex-wrap shadow mb-10">
         <button class="px-6 py-4 cursor-pointer"
             v-bind:class=" checkpoint.activeTab == 'clozes' ? ' bg-pink-500 text-white' : 'text-slate-50 bg-slate-700'"
             @click.prevent="checkpoint.setActiveTab('clozes')">clozes <span
                 v-text="checkpoint.form.clozes.length"></span></button>
         <button class="px-6 py-4 cursor-pointer"
             v-bind:class=" checkpoint.activeTab == 'flash cards' ? ' bg-pink-500 text-white' : 'text-slate-50 bg-slate-700'"
             @click.prevent="checkpoint.setActiveTab('flash cards')">Flash cards <span
                 v-text="checkpoint.form.flashCards.length"></span> </button>
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
     <div class="bg-white border border-slate-200 dark:border-white p-8">

         <h2 v-text="checkpoint.form.title" class="mb-6 text-2xl font-medium"></h2>
         <x-splade-input name="title" label="Checkpoint title/theme" class="mb-6"
             placeholder="Netzwerkkomponenten" />
         <div v-show="checkpoint.activeTab == 'clozes'">
             <x-forms.cloze-q-a :$rq />
         </div>
         <div v-show="checkpoint.activeTab == 'flash cards'">
             <x-forms.flash-card-q-a :$rq />
         </div>
     </div>
 </checkpoint>
