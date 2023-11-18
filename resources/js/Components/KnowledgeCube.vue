<script>

export default {

    props: {
        cube: Object,
        context: {
            type: String,
            default: 'preview'
        },
        filledFacesCount: Number,
        onPhone: Boolean,
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
            reordering: false,
            reorder: {index: null, position: null, reference: null},
            unwatch: null
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
        replaceTokensInText (textA, hideBridgeToken = true) {
            // Define a regular expression pattern to match tokens surrounded by "-- --"
            var regex = /\[(.*?)\]/g;
            // Replace matched tokens with the specified HTML span element
            var preview = textA.replace(regex, (match, token) => {
                const emptySpan = `<span class="bg-violet-500 text-white px-1 rounded">${hideBridgeToken ? '&nbsp;'.repeat(token.length) : token}</span>`;
                return emptySpan;
            });
            regex = /\*(.*?)\*/g;
            // Replace matched tokens with the specified HTML span element
            preview = preview.replace(regex, (match, token) => {
                const emptySpan = `<span class="bg-yellow-400/30 text-black dark:text-slate-300 px-1 rounded dark:bg-slate-800">${token}</span>`;
                return emptySpan;
            });
            return preview.replace(/\n/g, '<br>');
        },
        toggleReorder(reorderIdx){
            this.reordering = this.reorder.index != null;
            if(this.reordering){
                this.unwatch();
                this.reorder.index = null;
                this.reorder.position = null;
                this.reorder.reference = null;
                this.reordering = false;
            }else{
                this.reordering = true;
                this.unwatch = this.$watch('reorder', (newState, oldState) => {
                    if (newState.index != null && newState.position != null && newState.reference != null) {
                        let temp = this.cube.knowledge;
                        this.cube.knowledge = [];
                        this.$nextTick(() => {
                            const knowledge = temp.splice(newState.index, 1)[0];
                            const referenceNewIndex = newState.index > newState.reference ? newState.reference :  newState.reference - 1;
                            const newIndex = newState.position === 'before' ? referenceNewIndex : referenceNewIndex + 1;
                            temp.splice(newIndex, 0, knowledge);
                            this.cube.knowledge = temp;
                            temp = null;
                            this.toggleReorder(-1);
                        });
                    }
                }, { deep: true, immediate: true });
                this.reorder.index = reorderIdx;
            }
            return this.reordering;
        },
        setReorderingIndex (reorderIdx) {
            this.reorder.index = reorderIdx;
        },
        setReorderingBefore (index) {
            this.reorder.position = 'before';
            return this.toggleReorder(index);
        },
        setReorderingAfter (index) {
            this.reorder.position = 'after';
            return this.toggleReorder(index);
        },
        setReorderingReference (reordereingRef) {
            this.reorder.reference = reordereingRef;
        },

    },
    computed: {
        knowledgeCount(){
            const length = this.cube.knowledge.length;
            return length < 6 ? 6 : length;
        },
        nextFace(){
            const size = this.onPhone ? 160 : 250;
            return {
                'transform-style': 'preserve-3d',
                'transition': 'all 1s',
                'transform': (() => {
                    if (this.activeFace == 'front') {
                        return `translateZ(-${size}px) rotateY(0deg)`;
                    }
                    if (this.activeFace == 'right') {
                        return `translateZ(-${size}px) rotateY( -90deg)`;
                    }
                    if (this.activeFace == 'back') {
                        return `translateZ(-${size}px) rotateY(-180deg)`;
                    }
                    if (this.activeFace == 'left') {
                        return `translateZ(-${size}px) rotateY(90deg)`;
                        // return `translateZ(-${size}px) rotateY(-90deg)`;
                    }
                    if (this.activeFace == 'top') {
                        return `translateZ(-${size}px) rotateX( -90deg)`;
                    }
                    if (this.activeFace == 'bottom') {
                        return `translateZ(-${size}px) rotateX(  90deg)`;
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
            onPhone: this.onPhone,
            replaceTokensInText: this.replaceTokensInText,
            toggleReorder: this.toggleReorder,
            reordering: this.reordering,
            setReorderingIndex: this.setReorderingIndex,
            setReorderingBefore: this.setReorderingBefore,
            setReorderingAfter: this.setReorderingAfter,
            setReorderingReference: this.setReorderingReference,
            reorder: this.reorder,
        });
    },
};
</script>
