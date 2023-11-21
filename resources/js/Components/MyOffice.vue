<script>

export default {

    props: {
        subjects: Object,
        activeSubject: Object,
        activeSubjectTopics: Object,
        activeTopic: Object,
    },
    data () {
        return {
            mySubjects: this.subjects,
            myTopics: this.activeSubjectTopics,
            reordering: false,
            reorder: { index: null, position: null, reference: null },
            unwatch: null,
            reorderingMyTopics: false,
        }
    },
    methods: {
        toggleReorder (reorderIdx) {
            this.reordering = this.reorder.index != null;
            if (this.reordering) {
                this.unwatch();
                this.reorder.index = null;
                this.reorder.position = null;
                this.reorder.reference = null;
                this.reordering = false;
                this.reorderingMyTopics = false;
            } else {
                this.reordering = true;
                this.unwatch = this.$watch('reorder', (newState, oldState) => {
                    if (newState.index != null && newState.position != null && newState.reference != null) {
                        let temp = this.reorderingMyTopics ? this.myTopics : this.mySubjects;
                        if (this.reorderingMyTopics) {
                            this.myTopics = [];
                        } else {
                            this.mySubjects = [];
                        }
                        this.$nextTick(() => {
                            const target = temp.splice(newState.index, 1)[0];
                            const referenceNewIndex = newState.index > newState.reference ? newState.reference : newState.reference - 1;
                            const newIndex = newState.position === 'before' ? referenceNewIndex : referenceNewIndex + 1;
                            temp.splice(newIndex, 0, target);
                            if (this.reorderingMyTopics) {
                                this.myTopics = temp;
                                this.reorderingMyTopics = false;
                            } else {
                                this.mySubjects = temp;
                            }
                            temp = null;
                            this.toggleReorder(-1);
                            // this.$splade.emit('reordered');
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
        setReorderingBefore (index, reorderingMyTopics = false) {
            this.reorder.position = 'before';
            this.reorderingMyTopics = reorderingMyTopics;
            return this.toggleReorder(index);
        },
        setReorderingAfter (index, reorderingMyTopics = false) {
            this.reorder.position = 'after';
            this.reorderingMyTopics = reorderingMyTopics;
            return this.toggleReorder(index);
        },
        setReorderingReference (reordereingRef) {
            this.reorder.reference = reordereingRef;
        },

    },
    render () {
        return this.$slots.default({
            mySubjects: this.mySubjects,
            activeSubject: this.activeSubject,
            myTopics: this.myTopics,
            activeTopic: this.activeTopic,
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
