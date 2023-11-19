 <x-splade-modal position="center" :close-button="false">
     <knowledge v-slot="card" :initial-value="@js($knowledge)" :context="@js($context)">
         <div class="flex flex-col p-6 border rounded-md transition-all duration-500 mb-20">
             <div class="mb-2 relative font-medium">
                 <h2 class="text-lg first-letter:uppercase mb-4" v-text="@js($knowledge->knowledgeCube->subject)"></h2>
                 <button @click="modal.close" class="hidden lg:inline-flex text-sm absolute right-4 top-0">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM13.5 10.5h-6" />
                     </svg>
                 </button>
             </div>
             <hr class="border-slate-200 mb-4">
             <div class="mb-auto flex flex-col grow">
                 <div class="mb-3 leading-loose"
                     v-html="card.replaceTokensInText(card.knowledge.information, @js($context == 'test'))">
                 </div>
                 @if ($context != 'test')
                     <hr class="border-slate-300 my-6" v-if="card.knowledge.implications">
                     <div class="grow justify-self-end" v-html="@js($knowledge->implications)"></div>
                     @if ($knowledge->external_reference)
                         <div class="justify-self-end">
                             <a href="{{ $knowledge->external_reference }}" target="_blank" rel="noopener noreferrer"
                                 class="text-blue-400 dark:text-slate-100 dark:underline dark:underline-offset-2">
                                 Take me to the external reference
                             </a>
                         </div>
                     @endif
                 @endif
             </div>
         </div>
     </knowledge>
 </x-splade-modal>