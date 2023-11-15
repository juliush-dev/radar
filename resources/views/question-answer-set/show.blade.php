 <x-splade-modal position="bottom" :close-button="false">
     <div class="flex flex-col p-6 border rounded-md transition-all duration-500 mb-20">
         <div class="mb-2 relative font-medium">
             <h2 class="text-lg first-letter:uppercase mb-4" v-text="@js($qas->questionsCube->subject)"></h2>
             <h3 class="first-letter:uppercase" v-text="@js($qas->subject)"></h3>
             <button button type="button" @click="modal.close" class="text-sm absolute right-4 top-0">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM13.5 10.5h-6" />
                 </svg>
             </button>
         </div>
         <hr class="border-slate-200 mb-4">
         <div class="mb-auto flex flex-col grow">
             <div class="font-medium mb-3" v-html="@js($qas->question)"></div>
             @if ($context != 'test')
                 <div v-html="@js($qas->answer)"></div>
                 <hr class="border-slate-300 mb-3">
                 <div class="grow justify-self-end" v-html="@js($qas->answer_in_place_explanation)"></div>
                 @if ($qas->answer_explanation_redirect)
                     <div class="justify-self-end">
                         <a href="{{ $qas->answer_explanation_redirect }}" target="_blank" rel="noopener noreferrer"
                             class="text-blue-400 dark:text-slate-100 dark:underline dark:underline-offset-2">
                             Full explanation
                         </a>
                     </div>
                 @endif
             @endif
         </div>
     </div>
 </x-splade-modal>
