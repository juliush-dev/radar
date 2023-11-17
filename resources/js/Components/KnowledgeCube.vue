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
            showKnowledge: false,
        }
    },
    methods: {
        addKnowledge () {
            const content = {
                assisted: false,
                information: '',
                bridge: '',
                implications: '',
                external_reference: ''
            };
            this.cube.knowledge.push(content);
            this.$nextTick(() => {
                const newTextArea = this.$refs.textareas[this.cube.knowledge.length - 1];
                if (newTextArea) {
                    newTextArea.focus();
                }
            });
        },
        removeKnowledge (index = null) {
            if (isNaN(index) || index < 0 || index >= this.cube.knowledge.length) {
                console.error("Invalid index or index out of bounds");
                return;
            }
            var temp =  this.cube.knowledge;
            this.cube.knowledge = [];
            this.$nextTick(() => {
                this.cube.knowledge = temp.filter((e, i) => i != index);
                temp = null;
            });
        },
        next (activeFace, activeDeep, offset = null) {
            this.activeDeep = activeDeep > this.maxDeep ? 0 : activeDeep;
            this.activeFace = activeFace;
            if(offset == null){
                this.activeIndex + 1 >= this.knowledgeCount ? this.activeIndex = 0 : this.activeIndex++;
                this.activeFacePath.push(this.activeFace);
            }else{
                this.activeIndex = offset;
                this.activeFacePath = [];
                for (let index = 0; index <= offset; index++) {
                    this.activeFacePath.push(this.layout[index].face);
                }
            }
            // console.log(this.activeFacePath);
        },
        async previous () {
            var temp = this.activeIndex - 1;
            this.activeIndex = temp < 0 ? this.knowledgeCount - 1 : temp;
            this.activeDeep = Math.floor(this.activeIndex / this.cubeFacesCount);
            this.activeFacePath.pop();
            this.activeFace = temp = (this.activeFacePath.pop() ?? 'front');
            this.activeFacePath.push(temp);

        },
        toggleKnowledgeList(faceToGoto = null){
            if (faceToGoto != null && isNaN(faceToGoto) || faceToGoto < 0 || faceToGoto >= this.cube.knowledge.length) {
                console.error("Invalid faceToGoto or faceToGoto out of bounds");
                return;
            }
            this.showKnowledge = !this.showKnowledge;
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
        knowledgeCount(){
            const length = this.cube.knowledge.length;
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
            return Math.floor((this.knowledgeCount-1) / this.cubeFacesCount);
        }
    },
    render () {
        return this.$slots.default({
            cube: this.cube,
            addKnowledge: this.addKnowledge,
            removeKnowledge: this.removeKnowledge,
            activeIndex: this.activeIndex,
            knowledgeCount: this.knowledgeCount,
            next: this.next,
            previous: this.previous,
            nextFace: this.nextFace,
            activeDeep: this.activeDeep,
            context: this.context,
            filledFacesCount: this.filledFacesCount,
            toggleKnowledgeList: this.toggleKnowledgeList,
            showKnowledge: this.showKnowledge,
            // layout: this.layout,
            addLayer: this.addLayer,
            getLayout: this.getLayout,
        });
    },
};
</script>
