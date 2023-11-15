<questions-cube v-slot="questionsCube" :cube="@js(['subject' => $questionsCube->subject, 'questions' => $questionsCube->faces($reviewQuestions)])" :context="@js($context)"
    :filled-faces-count="@js($questionsCube->filledFacesCount($reviewQuestions))">
    <div class="scene w-96 h-96" style="perspective: 768px;">
        <div class="w-96 h-96 relative cube"
            style="transform-style: preserve-3d; transform: translateZ(-193px); transition: transform 1s;"
            v-bind:style="questionsCube.nextFace">
            <template v-for="(question, index) in questionsCube.cube.questions">
                <x-checkpoint.question :$context />
            </template>
        </div>
    </div>
</questions-cube>
