<questions-cube v-slot="questionsCube" :cube="@js(['subject' => $questionsCube->subject, 'questions' => $questionsCube->faces($reviewQuestions)])" :context="@js($context)"
    :filled-faces-count="@js($questionsCube->filledFacesCount($reviewQuestions))">
    <div class="h-96" style="perspective: 768px;">
        <div v-show="!questionsCube.showQuestions" class="scene w-96 h-96" style="perspective: 768px;">
            <div class="w-96 h-96 relative cube" style="transform-style: preserve-3d; transform: translateZ(-193px);"
                v-bind:style="questionsCube.nextFace">
                <template v-for="(question, index) in questionsCube.cube.questions">
                    <x-checkpoint.question :$context />
                </template>
            </div>
        </div>
        <div class="scene w-96 h-96" style="perspective: 768px;">
            <div class="relative cube">
                <ul v-if="questionsCube.showQuestions"
                    class="absolute bg-white dark:bg-slate-700 text-slate-100 border dark:border-slate-600 w-96 h-96 overflow-hidden overflow-y-auto flex flex-col gap-6 p-3 rounded-md shadow-lg"
                    @preserveScroll($questionsCube->id)>
                    <li v-html="questionsCube.cube.subject" class="font-medium"></li>
                    <template v-for="(question, index) in questionsCube.cube.questions">
                        <li v-if="question.answer.length > 0">
                            <button @click.prevent.stop="questionsCube.toggleQuestionsList(index)"
                                class="p-3 border dark:border-slate-600 shadow text-left w-full">
                                <p v-text="index + 1" class=" w-1/2 border-b dark:border-slate-600 text-xs mb-2"></p>
                                <div v-html="question.question" class="text-sm w-full"></div>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</questions-cube>
