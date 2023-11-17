<knowledge-cube v-slot="knowledgeCube" :cube="@js(['subject' => $knowledgeCube->subject, 'knowledge' => $knowledgeCube->faces($reviewKnowledge)])" :context="@js($context)"
    :filled-faces-count="@js($knowledgeCube->filledFacesCount($reviewKnowledge))">
    <div class="h-96" style="perspective: 768px;">
        <div v-show="!knowledgeCube.showKnowledge" class="scene w-96 h-96" style="perspective: 768px;">
            <div class="w-96 h-96 relative cube" style="transform-style: preserve-3d; transform: translateZ(-193px);"
                v-bind:style="knowledgeCube.nextFace">
                <template v-for="(knowledge, index) in knowledgeCube.cube.knowledge">
                    <x-checkpoint.knowledge :$context />
                </template>
            </div>
        </div>
        <div class="scene w-96 h-96" style="perspective: 768px;">
            <div class="relative cube">
                <ul v-if="knowledgeCube.showKnowledge"
                    class="absolute bg-white dark:bg-slate-700 dark:text-slate-100 border dark:border-slate-600 w-96 h-96 overflow-hidden overflow-y-auto flex flex-col gap-6 p-3 rounded-md shadow-lg"
                    @preserveScroll($knowledgeCube->id)>
                    <li v-html="knowledgeCube.cube.subject" class="font-medium"></li>
                    <template v-for="(knowledge, index) in knowledgeCube.cube.knowledge">
                        <li v-if="knowledge.information.length > 0">
                            <button @click.prevent.stop="knowledgeCube.toggleKnowledgeList(index)"
                                class="p-3 border dark:border-slate-600 shadow text-left w-full">
                                <p v-text="index + 1" class=" w-1/2 border-b dark:border-slate-600 text-xs mb-2"></p>
                                <div v-html="knowledge.bridge" class="text-sm w-full"></div>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</knowledge-cube>
