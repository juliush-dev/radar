 <question v-slot="card" :initial-content="question" :cube-faces-count="6" :index="index"
     :active-index="questionsCube.activeIndex" :context="@js($context)">
     <div v-show="card.deep == questionsCube.activeDeep" class="absolute w-96 h-96 dark:text-slate-700"
         v-bind:style="card.coordonates">
         <div class="flex flex-col w-96 h-96 p-6 border rounded-md transition-all duration-500 dark:border-slate-700"
             :class="card.style">
             <div class="mb-2">
                 <h2 class="text-lg first-letter:uppercase mb-3" v-text="questionsCube.cube.subject"></h2>
                 <h3 class="first-letter:uppercase" v-text="card.content.subject"></h3>
             </div>
             <hr class="border-slate-200 mb-4">
             <div class="mb-auto text-xs flex flex-col grow">
                 <div class="line-clamp-3 font-medium mb-3" v-html="card.content.question"></div>
                 <div v-show="!(card.context == 'test') || card.answerRevealed" class="line-clamp-3 mb-4"
                     v-html="card.content.answer"></div>
                 <hr v-if="((card.context == 'test') && card.answerRevealed && card.content.answer_in_place_explanation || !(card.context == 'test')) && card.content.answer.length > 0"
                     class="border-slate-300 mb-3">
                 <div v-if="(!(card.context == 'test') || card.answerRevealed) && card.content.answer_in_place_explanation"
                     class="line-clamp-4 grow justify-self-end" v-html="card.content.answer_in_place_explanation"></div>
                 <div v-if="(!(card.context == 'test') || card.answerRevealed) && card.content.answer_explanation_redirect"
                     class="line-clamp-4 mb-3 justify-self-end">
                     <a v-bind:href="`${card.content.answer_explanation_redirect}`" target="_blank"
                         rel="noopener noreferrer" class="text-blue-400"
                         v-bind:class="{'text-white underline underline-offset-2': card.answeredCorrectly != undefined}">
                         Full explanation
                     </a>
                 </div>
             </div>
             <div class="flex gap-6 justify-self-end mt-4">
                 <span class="border border-slate-500 rounded-full px-2 py-0.5 text-sm w-20 text-center"
                     v-bind:class="{'border-white': card.answeredCorrectly != undefined || card.answeredCorrectly == undefined && card.context == 'review'}"
                     v-text="`${card.index + 1}/${questionsCube.filledFacesCount}`"></span>
                 <Link modal v-bind:href="`/question-answer-set/${card.content.id}?context=${card.context}`"
                     v-if="card.content.answer.length > 0" class="text-sm">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                 </svg>
                 </Link>

                 <template v-if="(card.context == 'test') && card.content.answer.length > 0"
                     class="flex justify-center gap-6  items-center justify-self-center grow">
                     <div class="flex items-center" v-show="card.answerRevealed && card.answeredCorrectly == undefined">
                         <x-splade-form stay submit-on-change
                             v-bind:action="`/sessions/${session.content.id}/answers/${card.content.id}/wrong`"
                             class="flex items-center">
                             <button type="submit" class="transition-opacity duration-300 disabled:opacity-50"
                                 @click="card.setAnsweredCorrectly(false); session.resume(); form.submit = true;"
                                 :disabled="card.answeredCorrectly === false">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition-colors"
                                     v-bind:class="{'text-red-400': card.answeredCorrectly === false}">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                 </svg>
                             </button>
                         </x-splade-form>
                     </div>
                     <div class="flex items-center" v-show="!card.answerRevealed && !session.paused">
                         <x-splade-form stay
                             v-bind:action="`/sessions/${session.content.id}/answers/${card.content.id}/wrong`"
                             class="flex items-center">
                             <button type="submit" class="transition-opacity duration-300 disabled:opacity-50"
                                 @click="card.reveal(); session.pause();" :disabled="card.answeredCorrectly === false">
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
                     <div class="flex items-center" v-show="card.answerRevealed && card.answeredCorrectly == undefined">
                         <x-splade-form stay submit-on-change
                             v-bind:action="`/sessions/${session.content.id}/answers/${card.content.id}/correct`"
                             class="flex items-center">
                             <button type="submit" class="transition-opacity duration-300"
                                 @click="card.setAnsweredCorrectly(true); session.resume(); form.submit = true;"
                                 :disabled="card.answeredCorrectly">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition-colors"
                                     v-bind:class="{'text-green-400': card.answeredCorrectly}">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                 </svg>
                             </button>
                         </x-splade-form>
                     </div>
                 </template>

                 <button v-show="(card.context == 'test') && !session.paused || !(card.context == 'test')"
                     class="text-md ml-auto disabled:opacity-50" :disabled="card.index == 0"
                     @click="questionsCube.previous">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M21 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953l7.108-4.062A1.125 1.125 0 0121 8.688v8.123zM11.25 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953L9.567 7.71a1.125 1.125 0 011.683.977v8.123z" />
                     </svg>
                 </button>
                 <button v-show="(card.context == 'test') && !session.paused || !(card.context == 'test')"
                     class="text-md disabled:opacity-50" @click="questionsCube.next(card.nextFace, card.nextDeep)"
                     :disabled="card.index == questionsCube.questionsCount - 1">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M3 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062A1.125 1.125 0 013 16.81V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z" />
                     </svg>
                 </button>
             </div>
         </div>
     </div>
 </question>
