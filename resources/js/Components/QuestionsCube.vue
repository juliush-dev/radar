<script>
import { nextTick } from 'vue';

export default {

    props: {
        cube: Object,
        context: {
            type: String,
            default: 'preview'
        },
        filledFacesCount: Number,
    },
    data() {
        return {
            activeIndex: 0,
            minDeep: 0,
            activeDeep: 0,
            activeDeepPath: [0],
            activeFace: 'front',
            activeFacePath: ['front'],
            cubeFacesCount: 6,
        }
    },
    methods: {
          addQuestion (add_cloze = false) {
            const content = {
                is_assisted_cloze: false,
                is_cloze: add_cloze,
                is_flash_card: !add_cloze,
                title: '',
                question: '',
                answer: '',
                subject: '',
                answer_in_place_explanation: '',
                answer_explanation_redirect: ''
            };
            this.cube.questions.push(content);
            console.log(content);
        },
        removeQuestion (index = null) {
            console.log(index);
            if (isNaN(index)) {
                this.cube.questions = [];
            } else {
                this.cube.questions.splice(index, 1);
            }
        },
        next (activeFace, activeDeep) {
            this.activeIndex + 1 >= this.questionsCount ? this.activeIndex = 0 : this.activeIndex++;
            this.activeDeep = activeDeep > this.maxDeep ? 0 : activeDeep;
            this.activeFace = activeFace;
            this.activeFacePath.push(this.activeFace);
            // this.activeDeepPath.push(this.activeDeep);
        },
        async previous () {
            var temp = this.activeIndex - 1;
            this.activeIndex = temp < 0 ? this.questionsCount - 1 : temp;
            this.activeDeep = Math.floor(this.activeIndex / this.cubeFacesCount);
            this.activeFacePath.pop();
            this.activeFace = temp = (this.activeFacePath.pop() ?? 'front');
            this.activeFacePath.push(temp);

        },
    },
    computed: {
        questionsCount(){
            const length = this.cube.questions.length;
            return length < 6 ? 6 : length;
        },
        nextFace(){
            return {
                'transform': (() => {
                    if (this.activeFace == 'front') {
                        return 'translateZ(-191px) rotateY(0deg)';
                    }
                    if (this.activeFace == 'right') {
                        return 'translateZ(-191px) rotateY( -90deg)';
                    }
                    if (this.activeFace == 'back') {
                        return 'translateZ(-191px) rotateY(-180deg)';
                    }
                    if (this.activeFace == 'left') {
                        return 'translateZ(-191px) rotateY(90deg)';
                        // return 'translateZ(-191px) rotateY(-90deg)';
                    }
                    if (this.activeFace == 'top') {
                        return 'translateZ(-191px) rotateX( -90deg)';
                    }
                    if (this.activeFace == 'bottom') {
                        return 'translateZ(-191px) rotateX(  90deg)';
                    }
                })()
             }
        },
        maxDeep(){
            return Math.floor((this.questionsCount-1) / this.cubeFacesCount);
        }
    },
    render () {
        return this.$slots.default({
            cube: this.cube,
            addQuestion: this.addQuestion,
            removeQuestion: this.removeQuestion,
            activeIndex: this.activeIndex,
            questionsCount: this.questionsCount,
            next: this.next,
            previous: this.previous,
            nextFace: this.nextFace,
            activeDeep: this.activeDeep,
            context: this.context,
            filledFacesCount: this.filledFacesCount,
        });
    },
};
</script>
