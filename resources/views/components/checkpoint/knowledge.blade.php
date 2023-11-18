 <knowledge v-slot="card" :initial-value="knowledge" :cube-faces-count="6" :index="index"
     :active-index="knowledgeCube.activeIndex" :context="@js($context)" :cube="knowledgeCube">
     <div v-show="card.deep == knowledgeCube.activeDeep"
         class="absolute w-80 h-80 md:w-[500px] md:h-[500px] dark:text-slate-700" v-bind:style="card.coordonates">
         <div class="flex flex-col w-80 h-80 md:w-[500px] md:h-[500px] p-6 border rounded-md transition-all duration-75 dark:border-slate-700"
             v-bind:class="card.style">
             <h2 class="text-xl first-letter:uppercase mb-6 font-medium underline-offset-2 underline"
                 v-text="knowledgeCube.cube.subject"></h2>
             <div class="mb-auto text-xs md:text-lg flex flex-col grow">
                 <div class="line-clamp-3 lg:line-clamp-6 mb-6 text-base leading-loose"
                     v-html="card.replaceTokensInText(knowledge.information, !((card.context != 'test') || card.knowledgeRevealed))">
                 </div>
                 <div v-if="(!(card.context == 'test') || card.knowledgeRevealed) && card.knowledge.external_reference"
                     class="line-clamp-4 mb-3 justify-self-end">
                     <a v-bind:href="`${card.knowledge.external_reference}`" target="_blank" rel="noopener noreferrer"
                         class="text-blue-400"
                         v-bind:class="{'text-white underline underline-offset-2': card.bridgeCrossedSuccessfully != undefined}">
                         Take me to external reference
                     </a>
                 </div>
             </div>
             <div class="flex gap-6 justify-self-end mt-4">
                 <button @click="knowledgeCube.toggleKnowledgeList()"
                     class="border border-slate-500 rounded-full px-2 py-0.5 text-sm w-20 text-center"
                     v-bind:class="{'border-white': card.bridgeCrossedSuccessfully != undefined || card.bridgeCrossedSuccessfully == undefined && card.context == 'review'}"
                     v-text="`${card.index + 1}/${knowledgeCube.filledFacesCount}`"></button>
                 <Link modal v-bind:href="`/knowledge/${card.knowledge.id}?context=${card.context}`"
                     v-if="card.knowledge.information.length > 0" class="text-sm relative flex items-center">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                 </svg>
                 <span v-if="(!(card.context == 'test') || card.knowledgeRevealed) && card.knowledge.implications"
                     class="absolute flex h-3 w-3 right-0 -top-1">
                     <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                 </span>
                 </Link>

                 <template v-if="(card.context == 'test') && card.knowledge.information.length > 0"
                     class="flex justify-center gap-6  items-center justify-self-center grow">
                     <div class="flex items-center"
                         v-show="card.knowledgeRevealed && card.bridgeCrossedSuccessfully == undefined">
                         <x-splade-form stay submit-on-change
                             v-bind:action="`/sessions/${session.content.id}/bridges/${card.knowledge.id}/missed`"
                             class="flex items-center">
                             <button type="submit" class="transition-opacity duration-75 disabled:opacity-50"
                                 @click="card.setBridgeCrossedSuccessfully(false); session.resume(); form.submit = true;"
                                 :disabled="card.bridgeCrossedSuccessfully === false">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition-colors"
                                     v-bind:class="{'text-red-400': card.bridgeCrossedSuccessfully === false}">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                 </svg>
                             </button>
                         </x-splade-form>
                     </div>
                     <div class="flex items-center" v-show="!card.knowledgeRevealed && !session.paused">
                         <x-splade-form stay
                             v-bind:action="`/sessions/${session.content.id}/bridges/${card.knowledge.id}/missed`"
                             class="flex items-center">
                             <button type="submit" class="transition-opacity duration-75 disabled:opacity-50"
                                 @click="card.reveal(); session.pause();"
                                 :disabled="card.bridgeCrossedSuccessfully === false">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                 </svg>
                             </button>
                         </x-splade-form>
                     </div>
                     <div class="flex items-center"
                         v-show="card.knowledgeRevealed && card.bridgeCrossedSuccessfully == undefined">
                         <x-splade-form stay submit-on-change
                             v-bind:action="`/sessions/${session.content.id}/bridges/${card.knowledge.id}/crossed`"
                             class="flex items-center">
                             <button type="submit" class="transition-opacity duration-75"
                                 @click="card.setBridgeCrossedSuccessfully(true); session.resume(); form.submit = true;"
                                 :disabled="card.bridgeCrossedSuccessfully">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition-colors"
                                     v-bind:class="{'text-green-400': card.bridgeCrossedSuccessfully}">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                 </svg>
                             </button>
                         </x-splade-form>
                     </div>
                 </template>

                 <button v-show="(card.context == 'test') && !session.paused || !(card.context == 'test')"
                     class="text-md ml-auto disabled:opacity-50" :disabled="card.index == 0"
                     @click.prevent.stop="knowledgeCube.previous">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M21 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953l7.108-4.062A1.125 1.125 0 0121 8.688v8.123zM11.25 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953L9.567 7.71a1.125 1.125 0 011.683.977v8.123z" />
                     </svg>
                 </button>
                 <button v-show="(card.context == 'test') && !session.paused || !(card.context == 'test')"
                     class="text-md disabled:opacity-50"
                     @click.prevent.stop="knowledgeCube.next(card.nextFace, card.nextDeep)"
                     :disabled="card.index == knowledgeCube.knowledgeCount - 1">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M3 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062A1.125 1.125 0 013 16.81V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z" />
                     </svg>
                 </button>
             </div>
         </div>
     </div>
 </knowledge>
