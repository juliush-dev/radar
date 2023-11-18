@php
    $subject = $knowledgeCube->subject;
    $knowledge = $knowledgeCube->faces($reviewKnowledge);
@endphp
<knowledge-cube v-slot="knowledgeCube" :cube="@js(['subject' => $subject, 'knowledge' => $knowledge])" :context="@js($context)"
    :filled-faces-count="@js($knowledgeCube->filledFacesCount($reviewKnowledge))" :on-phone="@js(Agent::isPhone())">
    <div class="h-80 md:h-[500px]" v-bind:style="knowledgeCube.onPhone ? 'perspective: 640px;' : 'perspective: 1000px;'">
        <div v-show="!knowledgeCube.showKnowledge" class="scene w-80 h-80 md:w-[500px] md:h-[500px]"
            v-bind:style="knowledgeCube.onPhone ? 'perspective: 640px;' : 'perspective: 1000px;'">
            <div class="w-80 h-80 md:w-[500px] md:h-[500px] relative cube" style="transform-style: preserve-3d;"
                v-bind:style="knowledgeCube.nextFace">
                <template v-for="(knowledge, index) in knowledgeCube.cube.knowledge">
                    <x-checkpoint.knowledge :$context />
                </template>
            </div>
        </div>
        <div class="scene w-80 h-80 md:w-[500px] md:h-[500px]"
            v-bind:style="knowledgeCube.onPhone ? 'perspective: 640px;' : 'perspective: 1000px;'">
            <div class="relative cube">
                <ul v-if="knowledgeCube.showKnowledge"
                    class="absolute bg-white dark:bg-slate-700 dark:text-slate-100 border dark:border-slate-600 w-80 h-80 md:w-[500px] md:h-[500px] overflow-hidden overflow-y-auto flex flex-col gap-6 p-3 rounded-md shadow-lg"
                    @preserveScroll($knowledgeCube->id)>
                    <li v-html="knowledgeCube.cube.subject"
                        class="text-xl underline underline-offset-2 font-medium mt-4 px-3">
                    </li>
                    <template v-for="(knowledge, index) in knowledgeCube.cube.knowledge">
                        <li v-if="knowledge.information.length > 0">
                            <button @click.prevent.stop="knowledgeCube.toggleKnowledgeList(index)"
                                class="p-3 border dark:border-slate-600 shadow text-left w-full">
                                <p v-text="index + 1" class=" w-1/2 border-b dark:border-slate-600 text-base mb-2"></p>
                                <div v-html="knowledgeCube.replaceTokensInText(knowledge.information, (knowledgeCube.context == 'test'))"
                                    class="w-full leading-loose"></div>
                                <p v-if="knowledgeCube.context != 'test' && knowledge.implications "
                                    class="line-clamp-2 my-4 font-mono justify-self-end text-base border border-x-4 border-blue-400 pl-2 shadow">
                                    Implications availble.
                                </p>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</knowledge-cube>
