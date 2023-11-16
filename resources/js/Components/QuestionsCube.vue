<script>

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
            layout: [],
            cubeFacesCount: 6,
            showQuestions: false,
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
            if (isNaN(index) || index < 0 || index >= this.cube.questions.length) {
                console.error("Invalid index or index out of bounds");
                return;
            }
            var temp =  this.cube.questions;
            this.cube.questions = [];
            this.$nextTick(() => {
                this.cube.questions = temp.filter((e, i) => i != index);
                temp = null;
            });
        },
        next (activeFace, activeDeep, offset = null) {
            this.activeDeep = activeDeep > this.maxDeep ? 0 : activeDeep;
            this.activeFace = activeFace;
            if(offset == null){
                this.activeIndex + 1 >= this.questionsCount ? this.activeIndex = 0 : this.activeIndex++;
                this.activeFacePath.push(this.activeFace);
            }else{
                this.activeIndex = offset;
                this.activeFacePath = [];
                for (let index = 0; index <= offset; index++) {
                    this.activeFacePath.push(this.layout[index].face);
                }
            }
            console.log(this.activeFacePath);
        },
        async previous () {
            var temp = this.activeIndex - 1;
            this.activeIndex = temp < 0 ? this.questionsCount - 1 : temp;
            this.activeDeep = Math.floor(this.activeIndex / this.cubeFacesCount);
            this.activeFacePath.pop();
            this.activeFace = temp = (this.activeFacePath.pop() ?? 'front');
            this.activeFacePath.push(temp);

        },
        toggleQuestionsList(faceToGoto = null){
            if (faceToGoto != null && isNaN(faceToGoto) || faceToGoto < 0 || faceToGoto >= this.cube.questions.length) {
                console.error("Invalid faceToGoto or faceToGoto out of bounds");
                return;
            }
            this.showQuestions = !this.showQuestions;
            if (faceToGoto != null) {
                const layer = this.layout[faceToGoto];
                this.next(layer.face, layer.deep, faceToGoto);
            }
        },
        addLayer(layer){
            this.layout.push(layer);
        },
        getLayout (){
            return this.layout;
        },

    },
    computed: {
        questionsCount(){
            const length = this.cube.questions.length;
            return length < 6 ? 6 : length;
        },
        nextFace(){
            return {
                'transform-style': 'preserve-3d',
                'transition': 'all 1s',
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
                })(),
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
            toggleQuestionsList: this.toggleQuestionsList,
            showQuestions: this.showQuestions,
            // layout: this.layout,
            addLayer: this.addLayer,
            getLayout: this.getLayout,
        });
    },
};
</script>
